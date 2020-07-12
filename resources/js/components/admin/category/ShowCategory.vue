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
        <div v-if="initialSw" class="row mt-2">
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
                                    <button @click.prevent="editCategoryA(categoryA.id)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="deleteCategoryA(categoryA.id)" class="btn btn-sm btn-danger">Delt</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- v-if="initialSw" -->

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
                                    <button @click.prevent="editCategoryA(categoryA.id)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="deleteCategoryA(categoryA.id)" class="btn btn-sm btn-danger">Delt</button>
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
                                    <button @click.prevent="editCategoryA(categoryB.id)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="deleteCategoryA(categoryB.id)" class="btn btn-sm btn-danger">Delt</button>
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
                                    <button @click.prevent="editCategoryA(categoryC.id)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="deleteCategoryA(categoryC.id)" class="btn btn-sm btn-danger">Delt</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- v-if="categoryAsw" -->

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
                                    <button @click.prevent="editCategoryA(categoryB.categorya.id)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="deleteCategoryA(categoryB.categorya.id)" class="btn btn-sm btn-danger">Delt</button>
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
                                    <button @click.prevent="editCategoryA(categoryB.id)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="deleteCategoryA(categoryB.id)" class="btn btn-sm btn-danger">Delt</button>
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
                                    <button @click.prevent="editCategoryA(categoryC.id)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="deleteCategoryA(categoryC.id)" class="btn btn-sm btn-danger">Delt</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- v-if="categoryBsw" -->

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
                                    <button @click.prevent="editCategoryA(categoryC.categorya.id)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="deleteCategoryA(categoryC.categorya.id)" class="btn btn-sm btn-danger">Delt</button>
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
                                    <button @click.prevent="editCategoryA(categoryC.categoryb.id)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="deleteCategoryA(categoryC.categoryb.id)" class="btn btn-sm btn-danger">Delt</button>
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
                                    <button @click.prevent="editCategoryA(categoryC.id)" class="btn btn-sm btn-primary">Edit</button>
                                </td>
                                <td style="width: 10%;">
                                    <button @click.prevent="deleteCategoryA(categoryC.id)" class="btn btn-sm btn-danger">Delt</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- v-if="categoryCsw" -->
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
                initialSw: true,
            }
        },

        methods: {
            getCategoryAbyId(aId){
                axios.post('/admin/getCategoryAbyId',{
                    aId: aId,
                })
                .then(response => {
                    //console.log(response);
                    this.categoryA = response.data.categoryA;
                    this.categoryAsw = true;
                    this.categoryBsw = false;
                     this.categoryCsw = false;
                    this.initialSw = false;
                })
                .catch(error => {
                    //console.log(error);
                });
            },

            getCategoryBbyId(bId){
                axios.post('/admin/getCategoryBbyId',{
                    bId: bId,
                })
                .then(response => {
                    //console.log(response);
                    this.categoryB = response.data.categoryB;
                    this.categoryBsw = true;
                    this.categoryAsw = false;
                     this.categoryCsw = false;
                    this.initialSw = false;
                })
                .catch(error => {
                    //console.log(error);
                });
            },

            getCategoryCbyId(cId){
                axios.post('/admin/getCategoryCbyId',{
                    cId: cId,
                })
                .then(response => {
                    //console.log(response);
                    this.categoryC = response.data.categoryC;
                    this.categoryCsw = true;
                    this.categoryBsw = false;
                    this.categoryAsw = false;
                    this.initialSw = false;
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
