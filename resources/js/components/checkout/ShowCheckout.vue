<template>
    <div>
        <div v-if="errorMsg" class="row no-gutters">
            <div class="col-md-12 col-sm-12">
                <div class="display-4 mb-5">
                    {{ errorMsg }}
                </div>
            </div>
        </div>
        <div v-else>
            <div class="row no-gutters mb-4">
            <div class="bg-info text-center" style="border: 1px solid black; min-height: 80px; width: 100%; padding-top: 20px;">
                <h2>PAYMENT INFORMATIONS</h2>
            </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div>
                        <h4>Delivery address</h4>
                    </div>
                    <div style="border: 1px solid blue; width: 100%; height: 350px; overflow-y: scroll;">
                        <!-- autocomplete address api ==> test only -->
                        <!-- https://api.addy.co.nz/search?key=demo-api-key&s=80 Queen Street -->
                        <div class="row no-gutters">
                            <table class="table table-sm table-hover">
                                <tbody>
                                    <div style="border: 3px solid blue; width: 100%; height: 80px; overflow-y: scroll;">
                                        <tr @click.prevent="selectAddressName(address.id, address.address, address.addressee)" v-for="address in addresses" :key="address.index" class="existing_contents">
                                            <td style="width: 70%;">
                                                <a href="javascript: void(0)" class="text-dark text-decoration-none existing_address">
                                                    {{ address.address }}
                                                </a>
                                            </td>
                                            <td style="width: 20%;">
                                                <span class="existing_addressee">
                                                    {{ address.addressee }}
                                                </span>
                                            </td>
                                            <td style="width: 10%;">
                                                <button @click.prevent="deleteAddress(address.id)" class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    </div>
                                </tbody>
                            </table>
                        </div>
                        <div class="row no-gutters">
                            <table class="table table-sm table-borderless">
                                <tbody>
                                    <tr>
                                        <td style="width: 80%;" class="selected_address">

                                        </td>
                                        <td style="width: 20%;" class="selected_addressee">

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <form @submit.prevent="getAddressByApi()" id="findAddress">
                            <div class="row no-gutters">
                                <div class="col-md-10 col-sm-10">
                                    <input type="text" v-model="streetName" class="street_name form-control" required placeholder="Please type street no. and name if you need new.">
                                </div>
                                <div class="col-md-2 col-sm-2">
                                    <button class="btn btn-primary">Click</button>
                                </div>
                            </div>
                        </form>
                        <form @submit.prevent="getAddressee()" id="inputAddressee" class="mt-1">
                            <div class="row no-gutters">
                                <div class="col-md-10 col-sm-10">
                                    <input type="text" v-model="inputAddressee" class="street_name form-control" required placeholder="Please type addressee if you need new.">
                                </div>
                                <div class="col-md-2 col-sm-2">
                                    <button class="btn btn-primary">Click</button>
                                </div>
                            </div>
                        </form>
                        <div class="row no-gutters">
                            <table class="table table-hover table-sm table-dark">
                                <tbody class="address_section">
                                    <tr v-for="address in apiAutocomletedAddresses" :key="address.index">
                                        <td>
                                            <a href="javascript: void(0)" class="text-decoration-none text-white" @click.prevent="selectAddress(address.a)">{{ address.a }}</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h4>Terms and Conditions</h4>
                    </div>
                    <div style="border: 1px solid blue; width: 100%; height: 150px;">

                    </div>
                    <div class="mt-4">
                        <h4>Payment method</h4>
                    </div>
                    <div style="border: 1px solid blue; width: 100%; height: 140px;">

                    </div>
                </div>

                <div class="col-md-6 col-sm-6">
                    <div>
                        <h4>Products of your order</h4>
                    </div>
                    <div style="border: 1px solid blue; height: 300px; overflow-y: scroll;">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                    <tr v-for="(product) in products" :key="product.index">
                                        <td scope="row" style="width: 20%;">
                                            <a @click.prevent="productDetails(product['productId'])" target="_blank">
                                                <img :src="product['imagePath']" class="img-fluid img_thumb_nail" alt="">
                                            </a>
                                        </td>
                                        <td style="width: 80%;">
                                            <a @click.prevent="productDetails(product['productId'])" target="_blank" class="text-decoration-none text-dark">
                                                <div style="min-height: 80px;">
                                                    {{ product['name'] }}({{ product['productId'] }})
                                                </div>
                                                <div class="d-flex" style="min-height: 20px;">
                                                    <div v-if="product['price'] > product['salePrice']"  class="d-flex">
                                                        <div class="text-dark mr-3 text_decoration_line_through">{{ product['price'] | currency }}</div>
                                                        <div class="text-dark"><b>{{ product['salePrice'] | currency}}</b></div>
                                                    </div>
                                                    <div v-else class="d-flex">
                                                        <div class="text-dark"><b>{{ product['price'] | currency}}</b></div>
                                                    </div>
                                                    <div> &nbsp;/&nbsp;</div>
                                                    <div>{{ product['qty'] }} ea</div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td scope="row" colspan="2" class="text-center">
                                            <span><h5>{{ count }} item(s)</h5></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="mt-4">
                        <h4>Total Amount Informations</h4>
                    </div>
                    <div style="border: 3px solid blue; min-height: 206px;">
                        <div class="d-flex mt-2 mx-2">
                            <div class="w-50"><h4>Total Price</h4></div>
                            <div class="w-50 text-right"><h4>{{ (totalPrice) | currency}}</h4></div>
                        </div>
                        <div class="d-flex mt-2 mx-2">
                            <div class="w-50"><h4>Total Discounted</h4></div>
                            <div class="w-50 text-right"><h4>{{ ((totalPrice - totalSalePrice)) | currency }}</h4></div>
                        </div>
                        <div class="d-flex mt-2 mx-2">
                            <div class="w-50"><h4>Shipping Charge</h4></div>
                            <!-- shipping cost will be added in live mode below -->
                            <div class="w-50 text-right"><h4>{{ shippingCost | currency }}</h4></div>
                        </div>
                        <div class="d-flex mt-2 mx-2">
                            <div class="w-50"><h4>Grand Total</h4></div>
                            <!-- shipping cost will be added in live mode below -->
                            <div class="w-50 text-right"><h4>{{ ((totalSalePrice + 0)) | currency}}</h4></div>
                        </div>
                        <a href="#" @click.prevent="checkoutToPayNow()" class="text-decoration-none click_pay">
                            <div class="text-center bg-primary text-white" style="border: none; height: 60px; padding-top: 15px;">
                                <h4>Check Out</h4>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                errorMsg: "",
                addresses: {},
                products: {},
                count: "",
                totalPrice: "",
                totalSalePrice: "",
                streetName: "",
                apiAutocomletedAddresses: "",
                selectedAddressId: "",
                selectedAddressee: "",
                selectedAddress: "",
                inputAddressee: "",
                shippingCost: "",
            }
        },

        methods: {
            checkoutToPayNow(){
                if ((this.selectedAddress == "") || (this.selectedAddressee == "")){
                    alert("Please select address and addressee.");
                    return;
                }

                window.location.href = "/checkout/payNow" + '/' + this.selectedAddress + '/' + this.selectedAddressee + '/' + this.selectedAddressId;
            },

            getAddresses(){
                axios.get('/checkout/getAddresses',{
                    params: {
                        //
                    }
                })
                .then(response => {
                    //console.log(response);
                    this.addresses = response.data.addresses;
                })
                .catch(error => {

                });
            },

            deleteAddress(addressId){
                var message = "Do you want to delete this address?";
                var result = confirm(message);
                if (result == true) {
                    axios.post('/checkout/deleteAddress',{
                        id: addressId,
                    })
                    .then(response => {
                        //console.log(response);
                        this.errorMsg = "";
                        this.errorMsg = response.data.errorMsg;
                        if (!this.error){
                            this.getAddresses(addressId);
                            this.selectedAddressId = "";
                            this.selectedAddressee = "";
                            this.selectedAddress = "";
                            $('.selected_addressee').empty();
                            $('.selected_address').empty();
                        }
                    })
                    .catch(error => {
                        //console.log(error);
                        this.errorMsg = "";
                        this.errorMsg = error;
                    });
                }
            },

            getAddressee(){
                this.selectedAddressee = this.inputAddressee;
                $('.selected_addressee').empty().text(this.selectedAddressee);
                $('.selected_addressee').css('font-weight','bold');
            },

            selectAddress(address){
                this.selectedAddressId = "0";
                this.selectedAddress = address;
                $('.selected_address').empty().append(address);
                $('.selected_address').css('font-weight','bold');
            },

            selectAddressName(id, address, name){
                //alert(id + '     ' + address + '     ' + name);
                this.selectedAddressId = id;
                this.selectedAddressee = name;
                this.selectedAddress = address;
                $('.selected_addressee').empty().append(name);
                $('.selected_addressee').css('font-weight','bold');
                $('.selected_address').empty().append(address);
                $('.selected_address').css('font-weight','bold');
            },

            getAddressByApi(){
                axios.get('https://api.addy.co.nz/search',{
                    params: {
                        //apiKey="a88039a8124c4995a04f445d050de41a";
                        key: "demo-api-key",
                        s: this.streetName,
                    }
                })
                .then(response => {
                    //console.log(response);
                    this.apiAutocomletedAddresses = response.data.addresses;
                })
                .catch(error => {

                });
            },

            getCheckout(){
                axios.post('/checkout/getCheckout',{
                   //
                })
                .then(response => {
                    //console.log(response);
                    this.errorMsg = "";
                    this.errorMsg = response.data.errorMsg;
                    if (!this.errorMsg){
                        this.products = response.data.products;
                        this.count = response.data.count;
                        this.totalPrice = response.data.totalPrice;
                        this.totalSalePrice = response.data.totalSalePrice;
                        this.addresses = response.data.addresses;
                        this.shippingCost = response.data.shippingCost;
                    }
                })
                .catch(error => {
                    //console.log(error);
                    this.errorMsg = "";
                    this.errorMsg = error;
                });
            },
        },

        created() {
            this.getCheckout();
        },

        mounted() {

        }
    }
</script>
