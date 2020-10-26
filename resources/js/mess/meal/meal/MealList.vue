<template>
    <div>
        <div class="card-content collapse show">
            <div class="card-body card-dashboard">
                <table class="table table-striped table-bordered table-hover" v-if="resultData.data !=''">
                    <thead class="table_head">
                    <tr>
                        <th class="width-200">Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(value,index) in resultData">
                            <td>{{index}}</td>
                            <td  class="width-200 text-center">
                                <a v-if="permissions.indexOf('meal.destroy') !=-1"  @click="deleteData(index)" class="btn btn-danger btn-sm"><i aria-hidden="true" class="fa fa-trash-o btnColor"></i></a>
                                <a v-if="permissions.indexOf('meal.edit') !=-1" @click="openUpdateModal(index)" class="btn btn-primary btn-sm"><i aria-hidden="true" class="fa fa-pencil-square-o btnColor"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <ManageMeal :members="members"></ManageMeal>
    </div>
</template>

<script>

    import { EventBus } from './../../../vue-assets';
    import ManageMeal from './ManageMeal.vue';

    export default {
        components: {
            ManageMeal,
        },

        props:['permissions', 'members'],

        data: function(){
            return {
                resultData: {},
            };
        },

        methods: {
                index(){
                    axios.get(base_url+"meal?page=1").then((response) => {
                       this.resultData = response.data.data;
                    });
                },

                deleteData: function(date){
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
                            axios.delete(base_url+'meal/'+date).then((response) => {
                                _this.index();
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

                openUpdateModal(date){
                    EventBus.$emit('update-button-clicked', date);
                },

            },

            created() {
               var _this = this;
               _this.index();
                EventBus.$on('new-data-created', function () {
                    _this.index();
                });
            }

    }
</script>
