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

            <!-- 이 부분은 comment 시킬 것. for test uploading -->
            <!-- https://www.youtube.com/watch?v=RY6WhJTOIL0 -->
            <!-- https://www.youtube.com/watch?v=Py3iq7RZoUE -->
            <div class='form-group row'>
                <label class='col-sm-2 col-md-2 col-form-label'>Image Upload</label>
                <div class='col-sm-10 col-md-10'>
                    <input @change="selectedImages" type="file" multiple class="form-control" id="file" accept="image/.gif,.jpg,.png" required>
                    <div id="preview"></div><!--선택한 사진을 보여주기 위해 준비(프리뷰)-->
                    <div class="thumbnail_msg"></div><!--썸네일 준비중 메세지 보여주기-->
                </div>
                <div class="col-md-2 col-sm-2">
                </div>
                <!-- will be commented -->
                <!-- <div class="col-md-10 col-sm-10">
                    <button @click.prevent="addImages()" class="btn btn-sm btn-primary">Send</button>
                </div> -->
            </div>

            <!-- comment 할 것 -->
            <div class='form-group row'>
                <label class='col-sm-2 col-md-2 col-form-label'>Image Path</label>
                <div class='col-sm-10 col-md-10'>
                    <input type="text" class="form-control" v-model="form.imagePath" max="255" required>
                </div>
            </div>

            <!-- comment 할 것 -->
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
            {{ this.errorMsg }}
        </div>
        <!-- end of input form -->
    </div>
</template>

<script>
    export default {
        data(){
            return{
                errorMsg: "",
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
            ////https://www.youtube.com/watch?v=RY6WhJTOIL0
            ////https://www.youtube.com/watch?v=Py3iq7RZoUE
            selectedImages(e){ //for test
                //console.log(e)
                const maxWidth = 600;
                const maxHeight = 600;
                const maxCount = 3;
                window.URL = window.URL || window.webkitURL;
                var elBrowse = document.getElementById("file"),
                    elPreview = document.getElementById("preview"),
                    useBlob = false && window.URL; // `true` to use Blob instead of Data-URL

                function readImage(file) {
                    var reader = new FileReader();
                    reader.addEventListener("load", function () {
                        var image  = new Image();
                        image.addEventListener("load", function () {
                            var imageInfo = file.name    +' '+ // get the value of `name` from the `file` Obj
                                            image.width  +'×'+ // But get the width from our `image`
                                            image.height +' '+
                                            file.type    +' '+
                                            Math.round(file.size/1024) +'KB';
                            if (image.width > maxWidth || image.height > maxHeight){
                                alert(file.name + "'s width or height more than 600px.");
                                $('#preview').empty();
                                $('#file').val('');
                                $('.thumbnail_msg').empty();
                                return;
                            }
                            elPreview.appendChild(this);
                            //썸네일 준비중이라는 메세지 지우기
                            $('.thumbnail_msg').empty()
                        });
                        image.src = useBlob ? window.URL.createObjectURL(file) : reader.result;
                        if (useBlob) {
                            // Free some memory for optimal performance
                            window.URL.revokeObjectURL(file);
                        }
                    });
                    reader.readAsDataURL(file);
                }

                $('#preview').empty();
                var errors = "";
                let selectedFiles=e.target.files;
                //console.log(selectedFiles);
                if(!selectedFiles.length){
                    return false;
                }
                for(let i=0;i<selectedFiles.length;i++){
                    if (selectedFiles.length > maxCount){
                        alert("You can upload maxmum 3 photos.");
                        $('#preview').empty();
                        $('#file').val('');
                        break;
                    }
                    var file = selectedFiles[i];
                    if ((/\.(png|jpeg|jpg|gif)$/i).test(file.name)){
                        // SUCCESS! It's an image!
                        // Send our image `file` to our `readImage` function!
                        readImage(file);//call function
                        //썸네일 준비중 메세지
                        $('.thumbnail_msg').empty().append('<span style="color:red;">썸네일 준비중. 잠시 기다리세요...</span>');
                    } else {
                        errors += file.name +" Unsupported Image extension\n";
                    }
                }
                if (errors) {
                    alert(errors);
                    return
                }
            },

            addImages(){ //for test
                var files = document.getElementById('file').files;
                //console.log(files);

                var formData = new FormData();

                /* Utility function to convert a canvas to a BLOB */
                var dataURLtoBlob = function (dataURL) {
                    var BASE64_MARKER = ';base64,';
                    if (dataURL.indexOf(BASE64_MARKER) == -1) {
                        var parts = dataURL.split(',');
                        var contentType = parts[0].split(':')[1];
                        var raw = parts[1];

                        return new Blob([raw], { type: contentType });
                    }

                    var parts = dataURL.split(BASE64_MARKER);
                    var contentType = parts[0].split(':')[1];
                    var raw = window.atob(parts[1]);
                    var rawLength = raw.length;

                    var uInt8Array = new Uint8Array(rawLength);

                    for (var i = 0; i < rawLength; ++i) {
                        uInt8Array[i] = raw.charCodeAt(i);
                    }

                    return new Blob([uInt8Array], { type: contentType });
                }
                /* End Utility function to convert a canvas to a BLOB      */

                function resizeAndUpload(file) {
                    // Create a file reader
                    var reader = new FileReader();
                    reader.addEventListener("load", function (e) {
                        var img = new Image();  //
                        // Create an image
                        img.src = this.result;  //
                        var canvas = document.createElement("canvas");
                        var ctx = canvas.getContext("2d");
                        ctx.drawImage(img, 0, 0);
                        var width = 200;
                        var height = 200;
                        canvas.width = width;
                        canvas.height = height;
                        var ctx = canvas.getContext("2d");
                        ctx.drawImage(img, 0, 0, width, height);

                        var dataurl = canvas.toDataURL("image/jpeg");
                        var blob = dataURLtoBlob(dataurl);//call function

                        formData.append("files[]", blob,file.name);

                        axios.post('/seller/product/uploadImages',formData)
                        .then(response=>{
                            //success
                            console.log(response);
                        })
                        .catch(response=>{
                            //error
                        });

                    }, false);
                    reader.readAsDataURL(file);
                }//end of function resizeAndUpload(file)

                ////아래를 uncomment 하면 file 1 개씩 upload. 위 function 사용해 원하는 size를 만든다.
                // if (files) {
                //     [].forEach.call(files, resizeAndUpload);
                // }

                ////file을 multi로 보낼 수 있다. file size는 미리 준비 해야 한다.
                for(let i=0; i<files.length;i++){
                    formData.append('files[]',files[i]);
                }
                const config = { headers: { 'Content-Type': 'multipart/form-data' } };
                axios.post('/seller/product/uploadImages',formData,config)
                .then(response=>{
                    //success
                    console.log(response);
                })
                .catch(response=>{
                    //error
                });

                $('#preview').empty(); //clear
                $('#file').val(''); //clear
            },

            addProduct(){
                if (!this.selectedCategoryId){
                    alert("Please select category.");
                    return;
                }

                var formData = new FormData();
                var files = document.getElementById('file').files;
                for(let i=0; i<files.length;i++){
                    formData.append('files[]',files[i]);
                }
                formData.append('categoryAid', this.form.categoryAid);
                formData.append('categoryBid', this.form.categoryBid);
                formData.append('categoryCid', this.form.categoryCid);
                formData.append('productName', this.form.productName);
                formData.append('manufacturer', this.form.manufacturer);
                formData.append('normalPrice', this.form.normalPrice);
                formData.append('salePrice', this.form.salePrice);
                formData.append('countryOfOrigin', this.form.countryOfOrigin);
                formData.append('photoPaths', this.form.photoPaths);
                formData.append('imagePath', this.form.imagePath);
                formData.append('detailsPath', this.form.detailsPath);
                formData.append('skuNumber', this.form.skuNumber);
                formData.append('stockQty', this.form.stockQty);
                formData.append('ingredients', this.form.ingredients);
                formData.append('option', this.form.option);

                const config = { headers: { 'Content-Type': 'multipart/form-data' } };
                // axios.post('/seller/product/uploadImages',formData,config)
                axios.post('/seller/product/addProduct',formData,config)
                .then(response => {
                    //console.log(response);
                    this.errorMsg = response.data.errorMsg;
                    if (!this.errorMsg){
                        $('.error_message').empty();
                        this.newProductId = response.data.productId;
                        // this.resetForm();////clear form
                        if (this.newProductId){
                            // window.location.href = '/product/details' + '/' + id; //do not delete
                            ////commented for a while
                            //window.open('/product/details' + '/' + this.newProductId, '_blank') //for new window////show added product
                        }
                    }else{
                        $('.error_message').addClass('text-danger');
                    }
                })
                .catch(error => {
                    //console.log(error);
                    $('.error_message').empty().text(error).addClass('text-danger');
                });

                $('#preview').empty(); //clear
                $('#file').val(''); //clear

            //     axios.post('/seller/product/addProduct',{
            //         categoryAid : this.form.categoryAid,
            //         categoryBid : this.form.categoryBid,
            //         categoryCid : this.form.categoryCid,
            //         productName : this.form.productName,
            //         manufacturer : this.form.manufacturer,
            //         normalPrice : this.form.normalPrice,
            //         salePrice : this.form.salePrice,
            //         countryOfOrigin: this.form.countryOfOrigin,
            //         photoPaths : this.form.photoPaths,
            //         imagePath : this.form.imagePath,
            //         detailsPath : this.form.detailsPath,
            //         skuNumber: this.form.skuNumber,
            //         stockQty: this.form.stockQty,
            //         ingredients: this.form.ingredients,
            //         option: this.form.option,
            //     })
            //     .then(response => {
            //         //console.log(response);
            //         $('.error_message').empty();
            //         this.newProductId = response.data.productId;
            //         // this.resetForm();////clear form
            //         // window.location.href = '/product/details' + '/' + id; //do not delete
            //         window.open('/product/details' + '/' + this.newProductId, '_blank') //for new window////show added product
            //     })
            //     .catch(error => {
            //         //console.log(error);
            //         $('.error_message').empty().text(error).addClass('text-danger');
            //     });
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

            getCategoryBbyId(categoryAid,categoryAname){
                $('.categoryb_name').empty();
                $('.categoryc_name').empty();
                $('.categorya_name').empty().text(categoryAname);
                this.selectedCategoryId = "";
                this.blockSw = false;
                axios.get('/seller/product/getCategoryBbyId',{
                    params: {
                        aId: categoryAid,
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
