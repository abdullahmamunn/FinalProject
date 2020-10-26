<template>
    <div>
        <!-- Add Model-->
        <div class="modal fade text-left" id="addModel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary  white">
                        <h4 class="modal-title"> <b>Add Credit Info</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                     <form method="POST"  enctype="multipart/form-data" v-on:submit.prevent="store">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6" :class="{'has-danger': (errors.hasOwnProperty('date'))}">
                                    <label><b>Date</b><span class="requiredField">*</span></label>
                                    <datepicker placeholder="Select Date" v-model="form.date" :input-class="'form-control'" :format="dateFormat"></datepicker>
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('date'))">{{ (errors.hasOwnProperty('date')) ? errors.date[0] :'' }}</div>
                                </div>
                                <div class="form-group col-md-6" :class="{'has-danger': (errors.hasOwnProperty('member'))}">
                                    <label>Member<span class="requiredField">*</span></label>
                                    <multiselect
                                            v-model="form.member"
                                            :options="members"
                                            label="name"
                                            track-by="id"
                                            :show-labels="false"
                                    >
                                    </multiselect>
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('member'))">{{ (errors.hasOwnProperty('member')) ? errors.member[0] :'' }}</div>
                                </div>
                                <div class="form-group col-md-6" :class="{'has-danger': (errors.hasOwnProperty('amount'))}">
                                    <label><b>Amount</b><span class="requiredField">*</span></label>
                                    <input class="form-control" v-model="form.amount">
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('amount'))">{{ (errors.hasOwnProperty('amount')) ? errors.amount[0] :'' }}</div>
                                </div>
                                <div class="form-group col-md-6" :class="{'has-danger': (errors.hasOwnProperty('remarks'))}">
                                    <label><b>Remark</b></label>
                                    <textarea class="form-control" v-model="form.remarks"></textarea>
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('remarks'))">{{ (errors.hasOwnProperty('remarks')) ? errors.remarks[0] :'' }}</div>
                                </div>

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
                        <h4 class="modal-title"> <b>Edit Credit info</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST"  enctype="multipart/form-data" v-on:submit.prevent="update(form.id)">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6" :class="{'has-danger': (errors.hasOwnProperty('date'))}">
                                    <label><b>Date</b><span class="requiredField">*</span></label>
                                    <datepicker placeholder="Select Date" v-model="form.date" :input-class="'form-control'" :format="dateFormat"></datepicker>
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('date'))">{{ (errors.hasOwnProperty('date')) ? errors.date[0] :'' }}</div>
                                </div>
                                <div class="form-group col-md-6" :class="{'has-danger': (errors.hasOwnProperty('member'))}">
                                    <label>Member<span class="requiredField">*</span></label>
                                    <multiselect
                                            v-model="form.member"
                                            :options="members"
                                            label="name"
                                            track-by="id"
                                            :show-labels="false"
                                    >
                                    </multiselect>
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('member'))">{{ (errors.hasOwnProperty('member')) ? errors.member[0] :'' }}</div>
                                </div>
                                <div class="form-group col-md-6" :class="{'has-danger': (errors.hasOwnProperty('amount'))}">
                                    <label><b>Amount</b><span class="requiredField">*</span></label>
                                    <input class="form-control" v-model="form.amount">
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('amount'))">{{ (errors.hasOwnProperty('amount')) ? errors.amount[0] :'' }}</div>
                                </div>
                                <div class="form-group col-md-6" :class="{'has-danger': (errors.hasOwnProperty('remarks'))}">
                                    <label><b>Remark</b></label>
                                    <textarea class="form-control" v-model="form.remarks"></textarea>
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('remarks'))">{{ (errors.hasOwnProperty('remarks')) ? errors.remarks[0] :'' }}</div>
                                </div>

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
                form:{
                    date: '',
                    member: '',
                    amount: '',
                    remarks: '',
                },
                errors: {},
            };
        },

        methods:{
            store:function(){
                axios.post(base_url+'balance', this.form).then( (response) => {
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

            update:function (id) {
                axios.put(base_url+'balance/'+id, this.form).then( (response) => {
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

        },

        mounted(){
           var _this = this;
           $('#addModel,#editModel').on('hidden.bs.modal', function(){
               _this.errors = {};
               _this.form = {
                   date: '',
                   member: '',
                   total_meal: '',
                   remarks: '',
               };
           });

            EventBus.$on('update-button-clicked', (id) => {
                _this.errors = {};
                $('#editModel').modal("show");
                axios.get(base_url+'balance/'+id+'/edit').then((response) => {
                    _this.form = response.data.data;
                });
            });

        },
    }
</script>