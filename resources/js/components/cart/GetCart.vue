<template>
    <div>
        <div v-if="this.errorMsg" class="row no-gutters">
            <div class="col-md-6 offset-md-3 mt-5 mb-5">
                <strong class="display-4">{{ this.errorMsg }}</strong>
            </div>
        </div>

        <!-- row for table -->
        <div v-else class="row no-gutters">
            <!-- cart details -->
            <div class="col-md-9 col-sm-9">

                <h2>My Cart</h2>

                <table class="table table-sm table-borderless">
                    <tbody>
                        <tr>
                            <td scope="row" class="text-right"><a class="btn btn-sm btn-danger" @click="deleteAllInCart()">Delete All</a></td>
                        </tr>
                    </tbody>
                </table>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 40%;">Name</th>
                                <th style="width: 10%;"></th> <!-- picture -->
                                <th style="width: 7%;">Price</th>
                                <!-- <th style="width: 5%;">Sale</th> -->
                                <th style="width: 30%;">Qty</th>
                                <th style="width: 8%;" >Total</th>
                                <th style="width: 5%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product,index) in products" :key="product.index">
                                <td scope="row">
                                    <a href="javascript:void();" @click.prevent="details(product['productId'])" class="text-dark text-decoration-none">
                                        {{ product['name'] }}({{ product['productId'] }})
                                    </a>
                                </td>
                                <td><img :src="imagePath[index]" class="img-fluid img_thumb_nail" alt=""></td>
                                <td v-if="parseFloat(product['price']) > parseFloat(product['salePrice'])">
                                    <span class="text_decoration_line_through">{{ parseFloat(product['price']) | currency }}</span>
                                    <br>
                                    <b>{{ parseFloat(product['salePrice']) | currency}}</b>
                                </td>
                                <td v-else><b>{{ parseFloat(product['price']) | currency}}</b></td>
                                <td>
                                    <input type="number" min="1" max="99" v-model="qty[index]">
                                    <a class="btn btn-sm btn-primary" @click="editCart(product['productId'], qty[index])">Edit</a>
                                </td>
                                <!-- https://www.npmjs.com/package/vue-numeral-filter -->
                                <td v-if="parseFloat(product['price']) > parseFloat(product['salePrice'])">
                                    <span class="text_decoration_line_through">{{ ( parseFloat(product['price']) * parseFloat(qty[index])) | currency }}</span>
                                    <br>
                                    <b>{{ ( parseFloat(product['salePrice']) * parseFloat(qty[index])) | currency }}</b>
                                </td>
                                <td v-else><b>{{ ( parseFloat(product['price']) * parseFloat(qty[index])) | currency }}</b></td>
                                <td>
                                    <a class="btn btn-sm btn-danger" @click="deleteInCart(product['productId'])">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <!-- <td></td> -->
                                <td></td>
                                <td></td>
                                <td><a class="btn btn-sm btn-danger" @click="deleteAllInCart()">Delete All</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!-- end of cart details -->
            <!-- grand total -->
            <div class="col-md-3 col-sm-3">
                <div class="grand_total_box">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td scope="row" colspan="2" class="bg-primary text-center text-white" style="height:30px;">
                                        <h5>Grand Total</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" style="width:45%;">No. of items</td>
                                    <td class="text-right">{{ countOfItems }}</td>
                                </tr>
                                <tr>
                                    <td>Price</td>
                                    <td class="text-right">{{ totalPrice | currency }}</td>
                                </tr>
                                <tr>
                                    <td>Discounted</td>
                                    <td class="text-right">
                                        {{ (parseFloat(totalPrice) - parseFloat(totalSalePrice)) | currency}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ship. charge</td>
                                    <td class="text-right">$10.00</td>
                                </tr>
                                <tr>
                                    <td>Total amount</td>
                                    <td class="text-right">
                                        <h5>{{ (parseFloat(totalSalePrice) + parseFloat(shippingCost)) | currency  }}</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="bg-success text-center">
                                        <a href="/checkout/checkout" class="text-white text-decoration-none">
                                            <span class="order_now w-100 h-100">
                                                <h5>Order Now</h5>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- end of grand total -->
        </div><!-- end of row for table -->
    </div>
</template>

<script>
    export default {
        data(){
            return{
                products: {},
                totalPrice: {},
                totalSalePrice: {},
                errorMsg: null,
                successMsg: null,
                // qty: [],//only for example
                qty: {},
                imagePath: {},
                countOfItems: "",
                shippingCost: "",
            }
        },

        methods: {
            details(id){
                // window.location.href = '/product/details' + '/' + id; //do not delete
                window.open('/product/details' + '/' + id, '_blank') //for new window
            },

            editCart(id,qty){
                if (qty > 99)
                {
                    alert ("Qty should be less than 100 each.");
                    return;
                }
                axios.get('/cart/changeInCart',{
                    params: {
                        id: id,
                        qty: qty,
                    }
                })
                .then(response => {
                    //console.log(response);
                    this.successMsg = "";
                    this.errorMsg = "";
                    this.successMsg = response.data.successMsg;
                    this.errorMsg = response.data.errorMsg;
                    if (!this.errorMsg){
                        this.getCart();
                    }
                })
                .catch(error => {
                    //console.log(error);
                    this.successMsg = "";
                    this.errorMsg = "";
                    this.errorMsg = error;
                });
            },

            deleteInCart(id){
                var message = "Do you want to delete this product?";
                var result = confirm(message);
                if (result == true) {
                    axios.get('/cart/deleteInCart',{
                    params: {
                        id: id,
                    }
                    })
                    .then(response => {
                        //console.log(response);
                        this.successMsg = "";
                        this.errorMsg = "";
                        this.successMsg = response.data.successMsg;
                        this.errorMsg = response.data.errorMsg;
                        this.countOfItems = response.data.countOfItems;
                        $('.count_cart').empty().text(this.countOfItems);//change cart count in layout/app.blade.php
                        if (!this.errorMsg){
                            this.getCart();
                        }
                    })
                    .catch(error => {
                        //console.log(error);
                        this.successMsg = "";
                        this.errorMsg = "";
                        this.errorMsg = error;
                    });
                }
            },

            deleteAllInCart(){
                 var message = "Do you want to delete all of product?";
                var result = confirm(message);
                if (result == true) {
                    axios.get('/cart/deleteAllInCart',{
                    params: {

                    }
                    })
                    .then(response => {
                        //console.log(response);
                        this.successMsg = "";
                        this.errorMsg = "";
                        this.successMsg = response.data.successMsg;
                        this.errorMsg = response.data.errorMsg;
                        this.countOfItems = response.data.countOfItems;
                        $('.count_cart').empty().text(this.countOfItems);//change cart count in layout/app.blade.php
                    })
                    .catch(error => {
                        //console.log(error);
                        this.successMsg = "";
                        this.errorMsg = "";
                        this.errorMsg = error;
                    });
                }
            },

            getCart(){
                axios.get('/cart/getCart',{
                    //
                })
                .then(response => {
                    //console.log(response);
                    //get 3 objects from ProductController
                    this.products = response.data.products;
                    this.totalPrice = response.data.totalPrice;
                    this.totalSalePrice = response.data.totalSalePrice;
                    this.shippingCost = 10.00;
                    this.countOfItems = response.data.countOfItems;
                    this.errorMsg = response.data.errorMsg;
                    //// do not delete below
                    //// https://stackoverflow.com/questions/57047283/how-to-count-the-number-of-elements-in-this-particular-object
                    //console.log(Object.keys(this.products).length)
                    //var i;
                    // for (i = 0; i < (Object.keys(this.products).length); i++) {
                    //     console.log(Object.values(this.products))
                    // }
                    //// https://www.w3schools.com/js/js_loop_for.asp
                    //// https://www.itsolutionstuff.com/post/jquery-how-to-push-specific-key-and-value-in-arrayexample.html
                    var index;
                    for (index in this.products) {
                        //console.log(index);
                        //console.log (this.products[index]['qty']);
                        //this.qty.push(this.products[index]['qty'])=>for array,only for example
                        this.qty[index] = this.products[index]['qty']; //for object
                        this.imagePath[index] = this.products[index]['imagePath'];
                    }
                })
                .catch(error => {
                    //console.log(error);
                });
            },

        },

        created() {

            this.getCart();

        },

        mounted() {

        }
    }
</script>
