<template>
    <div class="col-md-6 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Others</h4>
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
                                <label><b>Logo</b></label>
                                <div class="col-md-6">
                                    <div class="col-md-2">
                                        <img :src="form.logo" class="img-responsive">
                                    </div>
                                    <div class="col-md-8">
                                        <input type="file" v-on:change="onFileChange" class="form-control">
                                    </div>
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
                    logo: ''
                },
            };
        },
        methods: {
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.form.logo = e.target.result;
                };
                reader.readAsDataURL(file);
            },
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
                logo: settings.logo ? base_url+ settings.logo : base_url+'images/company_logo.png',
            };
        }

    }
</script>
<style scoped>
    img{
        max-height: 200px;
    }
</style>

