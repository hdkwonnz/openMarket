<template>
    <div>
        <div v-if="errorMsg" class="row no-gutters">
            <div class="col-md-12 col-sm-12">
                <div class="text-danger">
                    <h4>{{ $errorMsg }}</h4>
                </div>
            </div>
        </div>
        <div v-else class="col-md-6 col-sm-6" style="margin-top: 100px; margin-bottom: 100px;">
            <h4>Input Card Details</h4>
            <form id="payment-form" class="my-4 mt-5">
                <div id="card-element">
                    <!-- Elements will create input elements here -->
                </div>

                <!-- We'll put the error messages in this element -->
                <div id="card-errors" role="alert"></div>

                <button class="btn btn-success mt-5 w-100" id="submit">Pay Now</button>
            </form>
            <div class="error_msg">
                <!-- All errors will be displayed here... 내가 추가... -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                clientSecret: "",
                errorMsg: "",
                userName: "",
            }
        },

        methods: {
            performStripe(){
                var stripe = Stripe("{{ env('STRIPE_PUB_KEY') }}");
                var elements = stripe.elements();
                var style = {
                    base: {
                    color: "#32325d",
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: "antialiased",
                        fontSize: "16px",
                            "::placeholder": {
                            color: "#aab7c4"
                        }
                    },
                    invalid: {
                        color: "#fa755a",
                        iconColor: "#fa755a"
                    }
                };
                var card = elements.create("card", { style: style, hidePostalCode: true });//hidePostalCode: true 내가추가...
                // var card = elements.create("card", { iconStyle: 'solid', style: style, hidePostalCode: true });//hidePostalCode: true, iconStyle: 'solid' 내가추가...
                card.mount("#card-element");

                card.addEventListener('change', ({error}) => {
                    const displayError = document.getElementById('card-errors');
                    if (error) {
                        displayError.classList.add('alert', 'alert-warning');
                        displayError.textContent = error.message;
                    } else {
                        displayError.classList.remove('alert', 'alert-warning');
                        displayError.textContent = '';
                    }
                });

                var form = document.getElementById('payment-form');
                var submitButton = document.getElementById('submit');////
                var customerName = this.userName;

                form.addEventListener('submit', function(ev) {
                    ev.preventDefault();
                    submitButton.disabled = true;////

                    stripe.confirmCardPayment((this.clientSecret), {
                        payment_method: {
                            card: card,
                            billing_details: {
                                name: customerName ////
                            }
                        }
                    })
                }); //form.addEventListener
            } //performStrip()
        }, //methodes

        created() {
            axios.get('/checkout/getPaymentIntent',{
                params: {

                }
            })
            .then(response => {
                //console.log(response);
                this.clientSecret = response.data.clientSecret;
                this.errorMsg = response.data.errorMsg;
                this.userName = response.data.userName;

                this.performStripe();
            })
            .catch(error => {
                //console.log(error);
            });
        },

        mounted() {

        }
    }
</script>
