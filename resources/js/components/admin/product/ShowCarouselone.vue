<template>
    <div>
        <div class="row no-gutters">
            <div style="border-top: 2px solid blue; min-height: 40px;
                    background-color: rgba(128, 128, 128, 0.42);
                    padding-top:10px;"
                    class="text-center w-100">
                    <span><h4>CAROUSEL-ONE EDIT</h4></span>
            </div>
        </div>
        <div class="row no-gutters mt-3">
            <div class="col-md-4 col-sm-4">
                <strong>PRODUCT ID</strong>
            </div>
            <div class="col-md-8 col-sm-8">
                <strong class="pl-2">IMAGE PATH</strong>
            </div>
        </div>
        <!-- input form -->
        <form @submit.prevent="editCarouselOne()" class="mt-1">
            <div v-if="carouselOnes">
                <div v-for="(carouselOne, index) in carouselOnes" :key="carouselOne.index">
                    <div class="form-group row">
                        <div class="col-md-4 col-sm-4">
                            <input type="text" class="form-control" v-model="productId[index]" required>
                        </div>
                        <div class="col-md-8 col-sm-8">
                            <input type="text" class="form-control"  v-model="imagePath[index]" required>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <div v-for="item in 3" :key="item.index">
                    <div class="form-group row">
                        <div class="col-md-4 col-sm-4">
                            <input type="text" class="form-control" v-model="productId[item]" required>
                        </div>
                        <div class="col-md-8 col-sm-8">
                            <input type="text" class="form-control"  v-model="imagePath[item]" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class='form-group row'>
                <div class='col-sm-4 col-md-4'>
                    <button class='btn btn-md btn-primary'>SUBMIT</button>
                </div>
            </div>
        </form>

        <div class="row no-gutters mt-3">
            <div class="col-md-6 col-sm-6">
                <div class="success_msg">
                    {{ successMsg }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                carouselOnes: {},
                imagePath: [],
                productId: [],
                carouselOneId: [],
                successMsg: "",
            }
        },

        methods: {
            editCarouselOne(){
                axios.post('/admin/product/editCarouselOne',{
                    imagePath: this.imagePath,
                    productId: this.productId,
                    carouselOneId: this.carouselOneId,
                })
                .then(response => {
                    //console.log(response);
                    this.successMsg = response.data.successMsg;
                })
                .catch(error => {
                    console.log(error);
                });
            }
        },

        created() {
           axios.post('/admin/product/getCarouselOne',{
                    //
            })
            .then(response => {
                //console.log(response);
                this.carouselOnes = response.data.carouselOnes;

                var carouselOne;
                var i = 0;
                for (carouselOne of this.carouselOnes) {
                   //console.log(carouselOne);
                   this.carouselOneId[i] = carouselOne.id;
                   this.imagePath[i] = carouselOne.image_path;
                   this.productId[i] = carouselOne.product_id;
                   i++;
                }
            })
            .catch(error => {
                console.log(error);
            });
        },

        mounted() {

        }
    }
</script>
