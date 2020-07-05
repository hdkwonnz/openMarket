<template>
    <div>
        <div class="row no-gutters">
            <div v-if="termSw" class="col-md-7 col-sm-7">
                <h4>ORDER DETAILS (by terms)</h4>
            </div>
            <div v-else class="col-md-7 col-sm-7">
                <h4>ORDER DETAILS (for last one month)</h4>
            </div>
            <div class="col-md-5 col-sm-5">
                <form @submit.prevent="orderDetailsByTerm()" >
                    From <input type="date" v-model="fromDate" name="fromDate" class="form-contorl from_date" required autofocus> To
                    <input type="date" v-model="toDate" name="toDate" class="form-contorl to_date" required>
                    <button type="" class="btn btn-sm btn-dark">Click</button>
                </form>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3 col-sm-3">
                <div class="left_side_menu">
                    <div style="border: 3px solid blue; min-height: 600px; width: 100%;">

                    </div>
                </div>
            </div>
            <div class="col-md-9 col-sm-9">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th style="width: 22%;">Date/Order#</th>
                                <th style="width: 43%;">Product Infos</th>
                                <th style="width: 15%;"></th>
                                <th style="width: 10%;">Delivery</th>
                                <th style="width: 10%;">Review</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tbody>
                            <tr v-for="(order) in orders" :key="order.index">
                                <td style="width: 20%;" scope="row">
                                    <div>
                                        {{ order.created_at | myDate }}
                                    </div>
                                    <div>Order# : {{ order.id }}</div>
                                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#orderDetailsModal">
                                        Details
                                    </a>
                                </td>
                                <td style="width: 80%;">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-borderless">
                                            <tbody>
                                                <tr v-for="detail in order.orderdetails" :key="detail.index">
                                                    <td style="width: 20%;" scope="row">
                                                        <img :src="detail.product.image_path" class="img-fluid img_thumb_nail" alt="">
                                                    </td>
                                                    <td style="width: 56%;">
                                                        <div>{{ detail.product.name }}</div>
                                                        <div>QTY : {{ detail.qty }} ea</div>
                                                        <div><b>${{ detail.sale_price }}</b></div>
                                                    </td>
                                                    <td style="width: 12%;">
                                                        Lorem ipsum dolor
                                                    </td>
                                                    <td style="width: 12%;">
                                                        <a href="#" class="btn btn-sm btn-secondary">Write</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>**end of data**</div>
            </div>
        </div><!--end of row-->

        <!-- order deatails modal-->
        <div class="modal fade" id="orderDetailsModal">
            <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Modal Heading</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div style="border: 3px solid blue; width: 100%; min-height: 500px;">
                        Modal body..
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
            </div>
        </div><!-- end of order deatails modal-->

    </div><!-- end of container -->
</template>

<script>
    export default {
        data(){
            return{
                orders: {},
                fromDate: "",
                toDate: "",
                termSw: false,
            }
        },

        methods: {
            orderDetailsByTerm(){
                ////https://stackoverflow.com/questions/25445377/how-to-get-current-date-without-time
                ////https://stackoverflow.com/questions/3605214/javascript-add-leading-zeroes-to-date
                var nowDate = new Date();
                var todayDate = nowDate.getFullYear()+'-'+
                                ((nowDate.getMonth()+1) < 10 ? "0"+(nowDate.getMonth()+1) : (nowDate.getMonth()+1))+'-'+
                                (nowDate.getDate() < 10 ? "0"+nowDate.getDate() : nowDate.getDate());
                // alert("todayDate = " + todayDate + "fromDate = " + this.fromDate + "toDate = " + this.toDate);
                if (this.fromDate > todayDate){
                    alert("Please select right 'from' date.")
                    return;
                }
                if (this.toDate > todayDate){
                    alert("Please select right 'to' date.")
                    return;
                }
                if (this.fromDate > this.toDate){
                    alert("'from' date is greater than 'to' date.")
                    return;
                }

                axios.get('/order/orderDetailsByTerm',{
                    params: {
                        fromDate: this.fromDate,
                        toDate: this.toDate,
                    }
                })
                .then(response => {
                    //console.log(response);
                    this.orders = response.data.orders;
                    this.termSw = true;
                })
                .catch(error => {
                    //console.log(error);
                });
            },

            getOrderDetails(){
                axios.get('/order/getOrderDetails',{
                    //
                })
                .then(response => {
                    //console.log(response);
                    this.orders = response.data.orders;
                })
                .catch(error => {
                    //console.log(error);
                });
            },
        },

        created() {

            this.getOrderDetails();

        },

        mounted() {

        }
    }
</script>
