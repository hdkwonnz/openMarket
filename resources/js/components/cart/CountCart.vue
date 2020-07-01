<template>
    <span>{{ this.countOfItems }}</span>
</template>

<script>
    export default {
        data(){
            return{
                countOfItems: "",
            }
        },

        created() {
           axios.get('/cart/countCart',{
                    params: {

                    }
                })
                .then(response => {
                    //console.log(response);
                    this.countOfItems = response.data.countOfItems;
                })
                .catch(error => {
                    //console.log(error);
                });
        },

        mounted() {

        }
    }
</script>
