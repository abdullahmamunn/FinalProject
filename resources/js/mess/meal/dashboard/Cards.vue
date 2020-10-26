<template>
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-primary bg-darken-2">
                            <i class="icon-camera font-large-2 white"></i>
                        </div>
                        <div class="p-2 bg-gradient-x-primary white media-body">
                            <h5>Meal Rate</h5>
                            <h5 class="text-bold-400 mb-0"> {{ (data.total_market / data.total_meal).toFixed(2) }} </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-danger bg-darken-2">
                            <i class="icon-user font-large-2 white"></i>
                        </div>
                        <div class="p-2 bg-gradient-x-danger white media-body">
                            <h5>Members</h5>
                            <h5 class="text-bold-400 mb-0">{{ data.total_members }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-warning bg-darken-2">
                            <i class="icon-basket-loaded font-large-2 white"></i>
                        </div>
                        <div class="p-2 bg-gradient-x-warning white media-body">
                            <h5>Balance</h5>
                            <h5 class="text-bold-400 mb-0">{{ data.total_balance }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-success bg-darken-2">
                            <i class="icon-wallet font-large-2 white"></i>
                        </div>
                        <div class="p-2 bg-gradient-x-success white media-body">
                            <h5>Total Market</h5>
                            <h5 class="text-bold-400 mb-0"> {{ data.total_market }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Cards',
        props: ['data'],
    }
</script>
