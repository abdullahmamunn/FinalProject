<template>
    <div class="col-md-6 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Application Cache Control</h4>
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
                    <div class="form-group">
                        <a  :href="base_url+'/clear-cache'" onclick="return confirm('Are you sure?')" class="btn btn-danger square btn-min-width mr-1 mb-1">Clear Application Cache</a>
                    </div>
                    <div class="form-group">
                        <a  :href="base_url+'/clear-model-cache'" onclick="return confirm('Are you sure?')" class="btn btn-danger square btn-min-width mr-1 mb-1">Clear Listing Data Cache</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['permissions'],
        data: function(){
            return {
                form: {

                },
                resultData: {},
                perPage: 10,
                base_url: base_url
            };
        },

        methods: {
            update(){
                let _this = this;
                axios.post(base_url+'setup/settings/update', _this.form).then( (response) => {
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

        }

    }
</script>

