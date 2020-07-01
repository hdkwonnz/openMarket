<style scoped>

</style>

<template>
    <div>
        <div class="row no-gutters">
            <div style="border-top: 2px solid blue; min-height: 40px;
                    background-color: rgba(128, 128, 128, 0.42);
                    padding-top:10px;"
                    class="text-center w-100">
                    <span><h4>RESISTER PRODUCT</h4></span>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4 col-sm-4">
                <h5><b>CATEGORY A</b></h5>
                <div class="w-100" style="height: 200px; overflow-y: auto;
                        border: 1px solid blue;">
                    <table class="table table-sm table-borderless table-hover">
                        <tbody>
                            <tr v-for="categoryA in categoryAs" :key="categoryA.index">
                                <td scope="row">
                                    <a href="#" @click.prevent="getCategoryBbyId(categoryA.id,categoryA.name)" class="text-decoration-none text-dark">
                                        {{ categoryA.name }}
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <h5><b>CATEGORY B</b></h5>
                <div class="w-100" style="height: 200px; overflow-y: auto;
                        border: 1px solid blue;">
                    <table class="table table-sm table-borderless table-hover">
                        <tbody>
                            <tr v-for="categoryB in categoryBs" :key="categoryB.index">
                                <td scope="row">
                                    <a href="#" @click.prevent="getCategoryCbyId(categoryB.categorya_id,categoryB.id,categoryB.name)" class="text-decoration-none text-dark">
                                        {{ categoryB.name }}
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <h5><b>CATEGORY C</b></h5>
                <div class="w-100" style="height: 200px; overflow-y: auto;
                        border: 1px solid blue;">
                    <table v-if="blockSw" class="table table-sm table-borderless table-hover">
                        <tbody>
                            <tr v-for="categoryC in categoryCs" :key="categoryC.index">
                                <td scope="row">
                                    <a href="#" @click.prevent="getCategorySelected(categoryC.categorya_id,categoryC.categoryb_id, categoryC.id,categoryC.name)" class="text-decoration-none text-dark">
                                        {{ categoryC.name }}
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row no-gutters mt-2">
            <h5 class="text-danger">Selected Category ==>&nbsp;</h5>
            <span class="categorya_name"></span>
            <span>&nbsp;</span>
            <span class="categoryb_name"></span>
            <span>&nbsp;</span>
            <span class="categoryc_name"></span>
        </div>

        <!-- input form -->
        <form @submit.prevent="addProduct()">
            <div class='form-group row'>
                <label class='col-sm-2 col-md-2 col-form-label'>Product Name</label>
                <div class='col-sm-10 col-md-10'>
                    <input type='text' class='form-control' maxlength='200' v-model="form.productName" required />
                </div>
            </div>

            <div class='form-group row'>
                <label class='col-sm-2 col-md-2 col-form-label'>Manufacturer</label>
                <div class='col-sm-10 col-md-10'>
                    <input type='text' class='form-control' maxlength='200' v-model="form.manufacturer" />
                </div>
            </div>

            <div class='form-group row'>
                <label class='col-sm-2 col-md-2 col-form-label'>Country of Origin</label>
                <div class='col-sm-4 col-md-4'>
                    <select class="form-control" v-model="form.countryOfOrigin" :required="true">
                        <option v-for="country in countries" :key="country.index" :value="country.value">
                            {{ country.text }}
                        </option>
                    </select>
                </div>
                <label class='col-sm-2 col-md-2 col-form-label'>Event Name</label>
                <div class='col-sm-4 col-md-4'>
                    <input type='text' class='form-control' v-model="form.eventName" maxlength='100'/>
                </div>
            </div>

            <div class='form-group row'>
                <label class='col-sm-2 col-md-2 col-form-label'>Normal Price</label>
                <div class='col-sm-2 col-md-2'>
                    <input type='number' class='form-control' v-model="form.normalPrice" min='0.1' step="any" required />
                </div>
                <label class='col-sm-2 col-md-2 col-form-label'>Sale Price</label>
                <div class='col-sm-2 col-md-2'>
                    <input type='number' class='form-control' v-model="form.salePrice" min='0.1' step="any" />
                </div>
                <label class='col-sm-2 col-md-2 col-form-label'>Stock Quantity</label>
                <div class='col-sm-2 col-md-2'>
                    <input type='number' class='form-control' v-model="form.stockQty" min='1' />
                </div>
            </div>

            <div class='form-group row'>
                <label class='col-sm-2 col-md-2 col-form-label'>Free Shipping?</label>
                <div class='col-sm-1 col-md-1'>
                    <input type='checkbox' class='form-control' v-model="isFreeShipping" true-value="yes" false-value="no"/>
                </div>
                <label v-if="this.isFreeShipping == 'no'" class='col-sm-2 col-md-2 col-form-label'>Delivery Cost</label>
                <div v-if="this.isFreeShipping == 'no'" class='col-sm-2 col-md-2'>
                    <input type='number' class='form-control' min='1'/>
                </div>
                <label class='col-sm-2 col-md-2 col-form-label'>Min. Purchase</label>
                <div class='col-sm-2 col-md-2'>
                    <input type='number' class='form-control' min='1'/>
                </div>
            </div>

            <div class="form-group row">
                <label class='col-sm-2 col-md-2 col-form-label'>SKU Number</label>
                <div class='col-sm-3 col-md-3'>
                    <input type="text" class="form-control" v-model="form.skuNumber">
                </div>
            </div>

            <div class='form-group row'>
                <label class='col-sm-2 col-md-2 col-form-label'>Any Options?</label>
                <div class='col-sm-1 col-md-1'>
                    <input type='checkbox' class='form-control' v-model="isOption" true-value="yes" false-value="no"/>
                </div>
                <label v-if="this.isOption == 'yes'" class='col-sm-2 col-md-2 col-form-label'>One Option</label>
                <div v-if="this.isOption == 'yes'" class='col-sm-1 col-md-1'>
                    <input type="radio" name="option" class="form-control" v-model="form.option" value="1"/>
                </div>
                <label v-if="this.isOption == 'yes'" class='col-sm-2 col-md-2 col-form-label'>Two Options</label>
                <div v-if="this.isOption == 'yes'" class='col-sm-1 col-md-1'>
                    <input type="radio" name="option" class="form-control" v-model="form.option" value="2"/>
                </div>
            </div>

            <div class='form-group row'>
                <label class='col-sm-2 col-md-2 col-form-label'>Image Path</label>
                <div class='col-sm-10 col-md-10'>
                    <input type="text" class="form-control" v-model="form.imagePath" max="255" required>
                </div>
            </div>

            <!-- https://www.digitalocean.com/community/tutorials/vuejs-iterating-v-for -->
            <div class='form-group row'>
                <label class='col-sm-2 col-md-2 col-form-label'>Photos Path</label>
                <div class='col-sm-10 col-md-10'>
                    <input v-for="item in 3" :key="item.index" type="text" max="255" class="form-control" v-model="form.photoPaths[item - 1]">
                </div>

            </div>

            <div class="form-group row">
                <label class='col-sm-2 col-md-2 col-form-label'>Details Path</label>
                <div class='col-sm-10 col-md-10'>
                    <input type="text" class="form-control" max="255" v-model="form.detailsPath">
                </div>
            </div>

            <div class="form-group row">
                <label class='col-sm-2 col-md-2 col-form-label'>Ingredients</label>
                <div class='col-sm-10 col-md-10'>
                    <textarea class='form-control' rows="5" v-model="form.ingredients"></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label class='col-sm-2 col-md-2 col-form-label'>Informations</label>
                <div class='col-sm-10 col-md-10'>
                    <input type="text" class="form-control">
                </div>
            </div>

            <div class='form-group row'>
                <div class='offset-sm-2 offset-md-2 col-sm-4 col-md-4'>
                    <button class='btn btn-lg btn-primary'>Add Product</button>
                </div>
            </div>
        </form>
        <div class="offset-md-2 offset-sm-2 col-md-10 col-sm-10 error_message">

        </div>
        <!-- end of input form -->
    </div>
</template>

<script>
    export default {
        data(){
            return{
                countries: [
                    { text: 'South Korea', value: 'South Korea' },
                    { text: 'China', value: 'China' },
                    { text: 'Tiwan', value: 'Tiwan' },
                    { text: 'Japan', value: 'Japan' },
                    { text: 'USA', value: 'USA' },
                    { text: 'Europ', value: 'Eu' },
                    { text: 'Etc', value: 'Etc' },
                ],
                selectedCategoryId: "",
                blockSw: false,
                newProductId: "",
                categoryAs: {},
                categoryBs: {},
                categoryCs: {},
                isOption: "no",
                isFreeShipping: "no",
                form: {
                    categoryAid: "",
                    categoryBid: "",
                    categoryCid: "",
                    productName : "",
                    manufacturer: "",
                    eventName: "",
                    normalPrice: "",
                    salePrice: "",
                    stockQty: "",
                    countryOfOrigin: "",
                    option: "",
                    imagePath: "",
                    photoPaths: [],
                    detailsPath: "",
                    skuNumber: "",
                    ingredients: "",
                },
            }
        },

        methods: {
            addProduct(){
                if (!this.selectedCategoryId){
                    alert("Please select category.");
                    return;
                }

                axios.post('/seller/product/addProduct',{
                    categoryAid : this.form.categoryAid,
                    categoryBid : this.form.categoryBid,
                    categoryCid : this.form.categoryCid,
                    productName : this.form.productName,
                    manufacturer : this.form.manufacturer,
                    normalPrice : this.form.normalPrice,
                    salePrice : this.form.salePrice,
                    countryOfOrigin: this.form.countryOfOrigin,
                    photoPaths : this.form.photoPaths,
                    imagePath : this.form.imagePath,
                    detailsPath : this.form.detailsPath,
                    skuNumber: this.form.skuNumber,
                    stockQty: this.form.stockQty,
                    ingredients: this.form.ingredients,
                    option: this.form.option,
                })
                .then(response => {
                    //console.log(response);
                    $('.error_message').empty();
                    this.newProductId = response.data.productId;
                    // this.resetForm();////clear form
                    // window.location.href = '/product/details' + '/' + id; //do not delete
                    window.open('/product/details' + '/' + this.newProductId, '_blank') //for new window////show added product
                })
                .catch(error => {
                    //console.log(error);
                    $('.error_message').empty().text(error).addClass('text-danger');
                });
            },

            resetForm() {
                Object.keys(this.form).forEach(key => {
                    return (this.form[key] = "");
                });
            },

            getCategorySelected(categoryAid,categoryBid,categoryCid,categoryCname){
                this.selectedCategoryId = categoryCid;
                this.form.categoryAid = categoryAid;
                this.form.categoryBid = categoryBid;
                this.form.categoryCid = categoryCid;
                $('.categoryc_name').empty().text('/ ' + categoryCname);
            },

            getCategoryCbyId(categoryAid,categoryBid,categoryBname){
                $('.categoryc_name').empty();
                $('.categoryb_name').empty().text('/ ' + categoryBname);
                this.selectedCategoryId = "";
                this.blockSw = true;
                axios.get('/seller/product/getCategoryCbyId',{
                    params: {
                        aId: categoryAid,
                        bId: categoryBid,
                    }
                })
                .then(response => {
                    //console.log(response);
                    this.categoryCs = response.data.categoryCs;
                })
                .catch(error => {
                    //console.log(error);
                });
            },

            getCategoryBbyId(id,categoryAname){
                $('.categoryb_name').empty();
                $('.categoryc_name').empty();
                $('.categorya_name').empty().text(categoryAname);
                this.selectedCategoryId = "";
                this.blockSw = false;
                axios.get('/seller/product/getCategoryBbyId',{
                    params: {
                        id: id,
                    }
                })
                .then(response => {
                    //console.log(response);
                    this.categoryBs = response.data.categoryBs;
                })
                .catch(error => {
                    //console.log(error);
                });
            },

            getCategoryAs(){
                axios.get('/seller/product/getCategoryAs',{
                    //
                })
                .then(response => {
                    //console.log(response);
                    this.categoryAs = response.data.categoryAs;
                })
                .catch(error => {
                    //console.log(error);
                });
            },
        },

        created() {
            this.getCategoryAs();
            this.form.countryOfOrigin = "South Korea";
            this.form.option = '1';
        },

        mounted() {

        }
    }
</script>
