<template>
    <div>
        <!-- Add Model-->
        <div class="modal fade text-left" id="addModel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary  white">
                        <h4 class="modal-title"> <b>Add Meal Info</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                     <form method="POST"  enctype="multipart/form-data" v-on:submit.prevent="store">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">

                                </div>
                                <div class="form-group col-md-4 " :class="{'has-danger': (errors.hasOwnProperty('date'))}">
                                    <label><b>Date</b><span class="requiredField">*</span></label>
                                    <datepicker placeholder="Select Date" v-model="form.date" :input-class="'form-control'" :format="dateFormat"></datepicker>
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('date'))">{{ (errors.hasOwnProperty('date')) ? errors.date[0] :'' }}</div>
                                </div>
                            </div>
                            <div class="row">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead class="table_head">
                                    <tr>
                                        <th class="width-200">Member</th>
                                        <th>Total Meal</th>
                                        <th>Remarks</th>
                                    </tr>
                                    </thead>
                                    <tbody v-if="form.meals && form.meals.length > 0">
                                    <template v-for="meal in form.meals">
                                        <tr v-if="meal.member.id">
                                            <td>#{{  meal.member.id }} - {{ meal.member.name }}</td>
                                            <td>
                                                <input type="text"  class="form-control" v-model="meal.total_meal" placeholder="Total Meal">
                                            </td>
                                            <td>
                                                <input class="form-control" v-model="meal.remarks" placeholder="Remarks">
                                            </td>
                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-default btn-min-width mr-1 mb-1" data-dismiss="modal"><i class="fa fa-refresh"></i> <b>Close</b></button>
                            <button type="submit" class="btn btn-primary btn-min-width mr-1 mb-1"><i class="fa fa-check"></i> <b>Save</b></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Model-->
        <div class="modal fade text-left" id="editModel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary  white">
                        <h4 class="modal-title"> <b>Edit Meal info</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST"  enctype="multipart/form-data" v-on:submit.prevent="update(form.date)">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">

                                </div>
                                <div class="form-group col-md-4 " :class="{'has-danger': (errors.hasOwnProperty('date'))}">
                                    <label><b>Date</b><span class="requiredField">*</span></label>
                                    <datepicker placeholder="Select Date" v-model="form.date" :input-class="'form-control'" :format="dateFormat"></datepicker>
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('date'))">{{ (errors.hasOwnProperty('date')) ? errors.date[0] :'' }}</div>
                                </div>
                            </div>
                            <div class="row">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead class="table_head">
                                    <tr>
                                        <th class="width-200">Member</th>
                                        <th>Total Meal</th>
                                        <th>Remarks</th>
                                    </tr>
                                    </thead>
                                    <tbody v-if="form.meals && form.meals.length > 0">
                                    <template v-for="meal in form.meals">
                                        <tr v-if="meal.member.id">
                                            <td>#{{  meal.member.id }} - {{ meal.member.name }}</td>
                                            <td>
                                                <input type="text" class="form-control" v-model="meal.total_meal" placeholder="Total Meal">
                                            </td>
                                            <td>
                                                <input class="form-control" v-model="meal.remarks" placeholder="Remarks">
                                            </td>
                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-default btn-min-width mr-1 mb-1" data-dismiss="modal"><i class="fa fa-refresh"></i> <b>Close</b></button>
                            <button type="submit" class="btn btn-primary btn-min-width mr-1 mb-1"><i class="fa fa-pencil-square-o"></i> <b>Update</b></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    import Datepicker from 'vuejs-datepicker';
    import { EventBus } from './../../../vue-assets';

    export default {
        props:['roleList', 'members'],
        components: {
            Multiselect,
            Datepicker
        },
        data:function(){
            return{
                form: {
                    date: new Date(),
                    meals: [
                        {
                            member: {},
                            total_meal: '',
                            remarks: '',
                        }
                    ],
                },
                errors: {},
            };
        },

        methods:{
            store:function(){
                axios.post(base_url+'meal', this.form).then( (response) => {
                    $('#addModel').modal('hide');
                    this.showMassage(response.data);
                    EventBus.$emit('new-data-created');
                })
                .catch(error => {
                    if(error.response.status == 422){
                        this.errors = error.response.data.errors;
                    }else{
                        this.showMassage(error);
                    }
                });
            },

            update:function (date) {
                axios.put(base_url+'meal/'+date, this.form).then( (response) => {
                    $('#editModel').modal('hide');
                    this.showMassage(response.data);
                    EventBus.$emit('new-data-created');
                })
                .catch(error => {
                    if(error.response.status == 422){
                        this.errors = error.response.data.errors;
                    }else{
                        this.showMassage(error);
                    }
                });
            },

            showMassage(data){
                if(data.status == 'success'){
                    toastr.success(data.message, 'Success');
                }else if(data.status == 'error'){
                    toastr.error(data.message, 'Error');
                }else{
                    toastr.error(data.message, 'Error');
                }
            },

            manageTable() {
                this.form.meals = [];
                for (let i = 0; i < this.members.length; i++) {
                    this.form.meals.push({
                        member: {id: this.members[i].id, name: this.members[i].name},
                        total_meal: 0,
                        remarks: '',
                    })
                }
            }
        },

        created () {
            setTimeout(() => {
                this.manageTable();
            },200)
        },

        mounted(){
           var _this = this;
           $('#addModel,#editModel').on('hidden.bs.modal', function(){
               _this.errors = {};
           });

            EventBus.$on('update-button-clicked', (date) => {
                this.form = {
                    date: new Date(),
                    meals: [],
                };

                _this.errors = {};
                $('#editModel').modal("show");
                axios.get(base_url+'meal/'+date+'/edit').then((response) => {
                    for (let i =0; i < response.data.data.meals.length; i++) {
                        this.form.meals.push({
                            member: response.data.data.meals[i].member,
                            total_meal: response.data.data.meals[i].total_meal,
                            remarks: response.data.data.meals[i].remarks,
                        })
                    }
                    _this.form.date = response.data.data.date;
                });
            });

        },
    }
</script>