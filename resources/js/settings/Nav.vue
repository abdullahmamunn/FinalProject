<template>
    <div class="col-md-6 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Company info</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-plus"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse">
                <div class="card-body card-dashboard">
                    <form>
                            <div class="form-group">
                                <label><b>Name</b></label>
                                <div class="col-md-6">
                                    <input type="text" v-model="form.name" placeholder="Enter App Name" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label><b>Address 1</b></label>
                                <div class="col-md-12">
                                    <textarea v-model="form.address1" class="form-control" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><b>Address 2</b></label>
                                <div class="col-md-12">
                                    <textarea v-model="form.address2" class="form-control" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><b>Phone</b></label>
                                <div class="col-md-6">
                                    <input type="text" v-model="form.phone" placeholder="Enter phone" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label><b>Email</b></label>
                                <div class="col-md-6">
                                    <input type="email" v-model="form.email" placeholder="Enter email" class="form-control">
                                </div>
                            </div>

                            <hr>
                            <div class="row pull-right">
                                <button type="button" @click.prevent="update" class="btn btn-primary">Update</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function(){
            return {
                form: {
                    name: '',
                    address1: '',
                    address2: '',
                    email: '',
                    phone: '',
                },
            };
        },

        methods: {
            update(){
                let _this = this;
                axios.post(base_url+'settings/update', _this.form).then( (response) => {
                    toastr.success(response.message, 'Success');
                }).catch(error => {
                    if(error.response.status == 422){
                        this.errors = error.response.data.errors;
                    }else{
                        this.showMassage(error);
                    }
                });
            }
        },
        created(){
            this.form = {
                name: settings.name ? settings.name : 'Mess BD',
                address1: settings.address1 ? settings.address1 : '',
                address2: settings.address2 ? settings.address2 : '',
                phone: settings.phone ? settings.phone : '',
                email: settings.email ? settings.email : 'hello@messbd.com',
            };
        }

    }
</script>

