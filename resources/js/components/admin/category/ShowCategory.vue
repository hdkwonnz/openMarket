<template>
    <div>
        <div class="row no-gutters">
            <div style="border-top: 2px solid blue; min-height: 40px;
                    background-color: rgba(128, 128, 128, 0.42);
                    padding-top:10px;"
                    class="text-center w-100">
                    <span><h4>CATEGORIES &nbsp;&nbsp;&nbsp;&nbsp;MANAGEMENT</h4></span>
            </div>
        </div>
        <div v-if="initializeSw" class="row no-gutters mt-2">
            <button @click.prevent="init()" class="btn btn-md btn-success">Initialize</button>
        </div>
        <div v-if="firstSw" class="row mt-2">
            <div class="col-md-4 col-sm-4">
                <h5><b>CATEGORY A</b></h5>
                <div class="w-100" style="height: 200px; overflow-y: auto;
                        border: 1px solid blue;">
                    <table class="table table-sm table-borderless table-hover">
                        <tbody>
                            <tr v-for="categoryA in categoryAs" :key="categoryA.index">
                                <td style="width: 80%;" scope="row">
                                    <a href="#" @click.prevent="getCategoryAbyId(categoryA.id)" class="text-decoration-none text-dark">
                                        {{ categoryA.name }}
                                    </a>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showEditCategoryA(categoryA.id, categoryA.name)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showDeleteCategoryA(categoryA.id,categoryA.name)" class="btn btn-sm btn-danger">Delt</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- v-if="firstSw" -->
        <div v-if="firstSw" class="row no-gutters">
            <div class="col-md-6 col-sm-6">
                <div style="border-top: 2px solid blue; min-height: 30px;
                    padding-top:5px;"
                    class="text-center w-100 mt-5 bg-dark text-white">
                    <span><h5>ADD CATEGORIES</h5></span>
                    <form @submit.prevent="addCategoryA()">
                        CAEGORY A <input type="text" v-model="categoryAname" required>
                        <button>Click</button>
                    </form>
                </div>
            </div>
        </div>

        <div v-if="categoryAsw" class="row mt-2">
            <div class="col-md-4 col-sm-4">
                <h5><b>CATEGORY A</b></h5>
                <div class="w-100" style="height: 200px; overflow-y: auto;
                        border: 1px solid blue;">
                    <table class="table table-sm table-borderless table-hover">
                        <tbody>
                            <tr>
                                <td style="width: 80%;" scope="row">
                                    <a href="#" @click.prevent="getCategoryAbyId(categoryA.id)" class="text-decoration-none text-dark">
                                        {{ categoryA.name }}
                                    </a>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showEditCategoryA(categoryA.id,categoryA.name)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showDeleteCategoryA(categoryA.id,categoryA.name)" class="btn btn-sm btn-danger">Delt</button>
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
                            <tr v-for="categoryB in categoryA.categorybs" :key="categoryB.index">
                                <td style="width: 80%;" scope="row">
                                    <a href="#" @click.prevent="getCategoryBbyId(categoryB.id)" class="text-decoration-none text-dark">
                                        {{ categoryB.name }}
                                    </a>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showEditCategoryB(categoryB.id,categoryB.name)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showDeleteCategoryB(categoryB.id,categoryB.name)" class="btn btn-sm btn-danger">Delt</button>
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
                    <table class="table table-sm table-borderless table-hover">
                        <tbody>
                            <tr style="width: 80%;" v-for="categoryC in categoryA.categorycs" :key="categoryC.index">
                                <td scope="row">
                                    <a href="#" @click.prevent="getCategoryCbyId(categoryC.id)" class="text-decoration-none text-dark">
                                        {{ categoryC.name }}
                                    </a>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showEditCategoryC(categoryC.id,categoryC.name)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showDeleteCategoryC(categoryC.id,categoryC.name)" class="btn btn-sm btn-danger">Delt</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- v-if="categoryAsw" -->
        <div v-if="categoryAsw" class="row no-gutters">
            <div class="col-md-6 col-sm-6">
                <div style="border-top: 2px solid blue; min-height: 30px;
                    padding-top:5px;"
                    class="text-center w-100 mt-5 bg-dark text-white">
                    <span><h5>ADD CATEGORIES</h5></span>
                    <form @submit.prevent="addCategoryB()">
                        CAEGORY B <input type="text" v-model="categoryBname" required>
                        <button>Click</button>
                    </form>
                </div>
            </div>
        </div>

        <div v-if="categoryBsw" class="row mt-2">
            <div class="col-md-4 col-sm-4">
                <h5><b>CATEGORY A</b></h5>
                <div class="w-100" style="height: 200px; overflow-y: auto;
                        border: 1px solid blue;">
                    <table class="table table-sm table-borderless table-hover">
                        <tbody>
                            <tr>
                                <td style="width: 80%;" scope="row">
                                    <a href="#" @click.prevent="getCategoryAbyId(categoryB.categorya.id)" class="text-decoration-none text-dark">
                                        {{ categoryB.categorya.name }}
                                    </a>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showEditCategoryA(categoryB.categorya.id,categoryB.categorya.name)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showDeleteCategoryA(categoryB.categorya.id,categoryB.categorya.name)" class="btn btn-sm btn-danger">Delt</button>
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
                            <tr>
                                <td style="width: 80%;" scope="row">
                                    <a href="#" @click.prevent="getCategoryBbyId(categoryB.id)" class="text-decoration-none text-dark">
                                        {{ categoryB.name }}
                                    </a>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showEditCategoryB(categoryB.id,categoryB.name)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showDeleteCategoryB(categoryB.id,categoryB.name)" class="btn btn-sm btn-danger">Delt</button>
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
                    <table class="table table-sm table-borderless table-hover">
                        <tbody>
                            <tr style="width: 80%;" v-for="categoryC in categoryB.categorycs" :key="categoryC.index">
                                <td scope="row">
                                    <a href="#" @click.prevent="getCategoryCbyId(categoryC.id)" class="text-decoration-none text-dark">
                                        {{ categoryC.name }}
                                    </a>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showEditCategoryC(categoryC.id,categoryC.name)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showDeleteCategoryC(categoryC.id,categoryC.name)" class="btn btn-sm btn-danger">Delt</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- v-if="categoryBsw" -->
        <div v-if="categoryBsw" class="row no-gutters">
            <div class="col-md-6 col-sm-6">
                <div style="border-top: 2px solid blue; min-height: 30px;
                    padding-top:5px;"
                    class="text-center w-100 mt-5 bg-dark text-white">
                    <span><h5>ADD CATEGORIES</h5></span>
                    <form @submit.prevent="addCategoryC()">
                        CAEGORY C <input type="text" v-model="categoryCname" required>
                        <button>Click</button>
                    </form>
                </div>
            </div>
        </div>

        <div v-if="categoryCsw" class="row mt-2">
            <div class="col-md-4 col-sm-4">
                <h5><b>CATEGORY A</b></h5>
                <div class="w-100" style="height: 200px; overflow-y: auto;
                        border: 1px solid blue;">
                    <table class="table table-sm table-borderless table-hover">
                        <tbody>
                            <tr>
                                <td style="width: 80%;" scope="row">
                                    <a href="#" @click.prevent="getCategoryAbyId(categoryC.categorya.id)" class="text-decoration-none text-dark">
                                        {{ categoryC.categorya.name }}
                                    </a>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showEditCategoryA(categoryC.categorya.id,categoryC.categorya.name)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showDeleteCategoryA(categoryC.categorya.id,categoryC.categorya.name)" class="btn btn-sm btn-danger">Delt</button>
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
                            <tr>
                                <td style="width: 80%;" scope="row">
                                    <a href="#" @click.prevent="getCategoryBbyId(categoryC.categoryb.id)" class="text-decoration-none text-dark">
                                        {{ categoryC.categoryb.name }}
                                    </a>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showEditCategoryB(categoryC.categoryb.id,categoryC.categoryb.name)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showDeleteCategoryB(categoryC.categoryb.id,categoryC.categoryb.name)" class="btn btn-sm btn-danger">Delt</button>
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
                    <table class="table table-sm table-borderless table-hover">
                        <tbody>
                            <tr style="width: 80%;">
                                <td scope="row">
                                    <a href="#" @click.prevent="getCategoryCbyId(categoryC.id)" class="text-decoration-none text-dark">
                                        {{ categoryC.name }}
                                    </a>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showEditCategoryC(categoryC.id,categoryC.categoryb.name)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="showDeleteCategoryC(categoryC.id,categoryC.categoryb.name)" class="btn btn-sm btn-danger">Delt</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- v-if="categoryCsw" -->

        <!-- The editModal -->
        <div class="modal" id="editModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Category Name</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="">
                            Category Name: <input type="text" v-model="categoryName">
                            <input type="hidden" v-model="categoryId">
                            <button class="btn btn-sm btn-secondary">EDIT</button>
                        </form>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div><!-- end of editModal -->

        <!-- The deleteModal -->
        <div class="modal" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Category Name</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="">
                            Category Name: <input type="text" v-model="categoryName">
                            <input type="hidden" v-model="categoryId">
                            <button class="btn btn-sm btn-secondary">Delete</button>
                        </form>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div><!-- end of deleteModal -->
    </div>
</template>

<script>
    export default {
        data(){
            return{
                categoryAs: {},
                categoryA: {},
                categoryB: {},
                categoryC: {},
                categoryAsw: false,
                categoryBsw: false,
                categoryCsw: false,
                firstSw: true,
                initializeSw: false,
                categoryName: "",
                categoryId: "",
                categoryAname: "",
                categoryBname: "",
                categoryCname: "",
                savedCategoryAid: "",
                savedCategoryBid: "",
                savedCategoryCid: "",
            }
        },

        methods: {
            addCategoryA(){
                alert("add categoryA...")
            },

            addCategoryB(){
                alert("add categoryB...")
            },

            addCategoryC(){
                alert("add categoryC...")
            },

            showDeleteCategoryA(aId,aName){
                //alert("delete A...")
                $('#deleteModal').modal('show');
                this.categoryName = aName;
                this.categoryId = aId;
            },

            showDeleteCategoryB(bId,bName){
                //alert("delete B...")
                $('#deleteModal').modal('show');
                this.categoryName = bName;
                this.categoryId = bId;
            },

            showDeleteCategoryC(cId,cName){
                //alert("delete C...")
                $('#deleteModal').modal('show');
                this.categoryName = cName;
                this.categoryId = cId;
            },

            showEditCategoryA(aId, aName){
                //alert("edit A...")
                $('#editModal').modal('show');
                this.categoryName = aName;
                this.categoryId = aId;
            },

            showEditCategoryB(bId,bName){
                //alert("edit B...")
                $('#editModal').modal('show');
                this.categoryName = bName;
                this.categoryId = bId;
            },

            showEditCategoryC(cId,cName){
                //alert("edit C...")
                $('#editModal').modal('show');
                this.categoryName = cName;
                this.categoryId = cId;
            },

            init(){
                this.getAllCategories();
                this.initializeSw = false;
                this.categoryAsw = false;
                this.categoryBsw = false;
                this.categoryCsw = false;
                this.firstSw = true;
            },

            getCategoryAbyId(aId){
                this.savedCategoryAid = aId;
                axios.post('/admin/getCategoryAbyId',{
                    aId: aId,
                })
                .then(response => {
                    //console.log(response);
                    this.categoryA = response.data.categoryA;
                    this.categoryAsw = true;
                    this.categoryBsw = false;
                    this.categoryCsw = false;
                    this.firstSw = false;
                    this.initializeSw = true;
                })
                .catch(error => {
                    //console.log(error);
                });
            },

            getCategoryBbyId(bId){
                this.savedCategoryBid = bId;
                axios.post('/admin/getCategoryBbyId',{
                    bId: bId,
                })
                .then(response => {
                    //console.log(response);
                    this.categoryB = response.data.categoryB;
                    this.categoryBsw = true;
                    this.categoryAsw = false;
                    this.categoryCsw = false;
                    this.firstSw = false;
                    this.initializeSw = true;
                })
                .catch(error => {
                    //console.log(error);
                });
            },

            getCategoryCbyId(cId){
                this.savedCategoryCid = cId;
                axios.post('/admin/getCategoryCbyId',{
                    cId: cId,
                })
                .then(response => {
                    //console.log(response);
                    this.categoryC = response.data.categoryC;
                    this.categoryCsw = true;
                    this.categoryBsw = false;
                    this.categoryAsw = false;
                    this.firstSw = false;
                    this.initializeSw = true;
                })
                .catch(error => {
                    //console.log(error);
                });
            },

            getAllCategories(){
                axios.post('/admin/getAllcategories',{
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
            this.getAllCategories();

        },

        mounted() {

        }
    }
</script>
