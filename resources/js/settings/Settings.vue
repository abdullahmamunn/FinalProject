<template>
    <div>
        <div class="row match-height">
            <Nav></Nav>
            <Cache></Cache>
            <LoginPage></LoginPage>
        </div>

    </div>

</template>

<script>
    import Nav from './Nav.vue';
    import Cache from './Cache.vue';
    import LoginPage from './LoginPage.vue';

    export default {
        components: {
            Nav,Cache,LoginPage
        },
        data: function(){
            return {

            };
        }
    }
</script>

