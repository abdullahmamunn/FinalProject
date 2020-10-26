<template>
    <div>
        <Cards :data="cardData"></Cards>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-12">
                <div class="card">
                    <div class="card-content">
                        <h3 style="text-align: center">{{ current_month }}</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                <tr>
                                    <th v-for="(item, index) in head">{{ item }}</th>
                                    <th>Per Day Meal</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(date, index) in meals">
                                    <td v-for="item in date">{{ item }}</td>
                                    <td>{{ perDayTotal(date) }}</td>
                                </tr>
                                <tr>
                                    <th v-for="(item, index) in footer">{{ item }}</th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Cards from  './Cards.vue';
    import Pagination from  './../../../components/Pagination.vue';

    export default {
        name: 'MealDashboard',
        components: {
            Pagination,
            Cards
        },

        props:['permissions'],

        data: function(){
            return {
                cardData: [],
                head: {},
                meals: {},
                footer: {},
                current_month: {},
                perPage: 10
            };
        },

        methods: {
            perDayTotal (date) {
                let total = 0;
                let array = Object.values(date);

                for (let i = 1; i < array.length; i++) {
                    total += array[i];
                }

                return total;
            },
            index(pageNo,perPage){
                if(pageNo){ pageNo = pageNo; }else{pageNo = this.resultData.current_page; }
                if(perPage){ perPage = perPage;}else{ perPage = this.perPage;}

                axios.get(base_url+"mess-meal/overview?page="+pageNo+"&perPage="+perPage).then((response) => {
                   this.head = response.data.head;
                   this.meals = response.data.meals;
                   this.footer = response.data.footer;
                   this.current_month = response.data.current_month;
                   this.cardData = response.data.card_data;
                });
            },

        },

        created() {
           this.index(1);
        }

    }
</script>
