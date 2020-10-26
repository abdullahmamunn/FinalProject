<template>
    <div>
        <div class="card-content collapse show">
            <div class="card-body card-dashboard">
                <div class="item-show-limit">
                    <span>Show</span>
                    <select name="per_page" class="per_page" @change="changePerPage" v-model="perPage">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                    </select>
                    <span>Entries</span>
                </div>

                <table class="table table-striped table-bordered table-hover">
                    <thead class="table_head">
                    <tr>
                        <th class="width-200">Date</th>
                        <th>Member</th>
                        <th>Cost</th>
                        <th>Remarks</th>
                        <th>Updated By</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody v-if="resultData.data !=''">
                        <tr v-for="(value,index) in resultData.data">
                            <td>{{value.date}}</td>
                            <td>{{value.member.name}}</td>
                            <td>{{value.cost}}</td>
                            <td>{{value.remarks}}</td>
                            <td>{{value.updated_by.name}}</td>
                            <td  class="width-200 text-center">
                                <a v-if="permissions.indexOf('market.destroy') !=-1"  @click="deleteData(value.id)" class="btn btn-danger btn-sm"><i aria-hidden="true" class="fa fa-trash-o btnColor"></i></a>
                                <a v-if="permissions.indexOf('market.edit') !=-1" @click="openUpdateModal(value.id)" class="btn btn-primary btn-sm"><i aria-hidden="true" class="fa fa-pencil-square-o btnColor"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="text-center col-md-12" >
                        <pagination :resultData="resultData" @clicked="index" :mid-size="9"></pagination>
                    </div>
                </div>

            </div>
        </div>

        <ManageMarket :members="members"></ManageMarket>
    </div>
</template>

<script>

    import { EventBus } from './../../../vue-assets';
    import ManageMarket from './ManageMarket.vue';
    import Pagination from  './../../../components/Pagination.vue';

    export default {
        components: {
            ManageMarket,
            Pagination
        },

        props:['permissions', 'members'],

        data: function(){
            return {
                resultData: {},
                perPage: 10
            };
        },

        methods: {
                index(pageNo,perPage){
                    if(pageNo){ pageNo = pageNo; }else{pageNo = this.resultData.current_page; }
                    if(perPage){ perPage = perPage;}else{ perPage = this.perPage;}

                    axios.get(base_url+"market?page="+pageNo+"&perPage="+perPage).then((response) => {
                       this.resultData = response.data;
                    });
                },

                deleteData: function(id){
                    var _this = this;
                    swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this file!",
                        icon: "warning",
                        showCancelButton: true,
                        buttons: {
                            cancel: {
                                text: "No, cancel pls!",
                                value: null,
                                visible: true,
                                className: "btn-warning",
                                closeModal: true,
                            },
                            confirm: {
                                text: "Yes, delete it!",
                                value: true,
                                visible: true,
                                className: "",
                                closeModal: true
                            }
                        }
                    }).then(isConfirm => {
                        if (isConfirm) {
                            axios.delete(base_url+'market/'+id).then((response) => {
                                _this.index(1);
                                 _this.showMassage(response.data);
                            }).catch((error)=>{
                                 _this.showMassage(response.data);
                            });
                        }
                    });
                },

                showMassage(data) {
                    if (data.status == 'success') {
                        toastr.success(data.message, 'Success Alert', {timeOut: 5000});
                    } else {
                        toastr.error(data.message, 'Error Alert', {timeOut: 5000});
                    }
                },

                openUpdateModal(id){
                    EventBus.$emit('update-button-clicked', id);
                },

                changePerPage(){
                    var vm = this;
                    vm.index(1,vm.perPage);
                },

            },

            created() {
               var _this = this;
               _this.index(1);
                EventBus.$on('new-data-created', function () {
                    _this.index(1);
                });
            }

    }
</script>
