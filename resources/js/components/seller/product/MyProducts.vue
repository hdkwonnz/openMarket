<template>
    <div>
        <div class="row no-gutters">
            <div class="col-md-6 col-sm-6">
                <h4>My Products</h4>
            </div>
            <div class="col-md-6 col-sm-6">
                <!-- Search -->
                <form @submit.prevent="searchProduct()" class="form-inline">
                    <input type="text" v-model="searchTerm" class="form-control" style="width: 400px;" placeholder="Search in my products" aria-label="Search" required />
                    <button class="btn btn-outline-success">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="table-responsive mt-1">
                <table class="table table-bordered table-hover table-dark">
                    <thead>
                        <tr>
                            <th style="width: 68%;">Name</th>
                            <th style="width: 5%;">Status</th>
                            <th style="width: 12%;">Price</th>
                            <th style="width: 10%;">Created At</th>
                            <th style="width: 5%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products" :key="product.index">
                            <td scope="row">
                                {{ product.name }}({{ product.id }})
                            </td>
                            <td>
                                {{ product.status }}
                            </td>
                            <td>
                                ${{ product.price }} / ({{ product.sale_price }})
                            </td>
                            <td>
                                {{ product.created_at | myDate}}
                            </td>
                            <td>
                                <a href="javascript:void(0) return false;" @click.prevent="editProduct(product.id)" class="text-center">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                searchTerm: "",
                products: {},
            }
        },

        methods: {
            searchProduct(){
                alert("search term...")
            },

            editProduct(productId){
                window.open('/seller/product/showEditProduct' + '/' + productId, '_blank')
            },

            getMyProducts(){
                axios.get('/seller/product/getMyProducts',{
                    //
                })
                .then(response => {
                    //console.log(response);
                    this.products = response.data.products;
                })
                .catch(error => {
                    //console.log(error);
                });
            },
        },

        created() {
            this.getMyProducts();
        },

        mounted() {

        }
    }
</script>
