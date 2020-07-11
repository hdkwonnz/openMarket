@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="loading_spiner">
        <!-- spiner will be showing here -->
    </div>
    @if ($errorMsg)
        <div class="row no-gutters">
            <div class="col-md-12 col-sm-12">
                <div class="display-4 mb-5">
                    {{ $errorMsg }} <!-- errorMsg comes from CheckoutController@payNow  -->
                </div>
            </div>
        </div>
    @else
    <div class="col-md-6 col-sm-6" style="margin-top: 100px; margin-bottom: 100px;">
        <div class="d-flex m-0 p-0">
            <h4>Input Card Details</h4>
            <i class="fab fa-cc-visa fa-3x ml-4"></i>
            <i class="fab fa-cc-mastercard fa-3x ml-2"></i>
        </div>
        <div class="row form-group mt-5">
            <label for="address" class="col-md-3 col-form-label">ADDRESS</label>
            <input type="text" class="address col-md-9 form-control" value="{{ $address }}" readonly>
        </div>
        <div class="row form-group">
            <label for="name" class="col-md-3 col-form-label">ADDRESSEE</label>
            <input type="text" class="addressee col-md-9 form-control" value="{{ $addressee }}" readonly>
        </div>
        <form id="payment-form" action="" method="POST" class="my-4 mt-5">
            @csrf
            <div id="card-element" class="col-md-12 col-sm-12 mt-1">
                <!-- Elements will create input elements here -->
            </div>

            <!-- We'll put the error messages in this element -->
            <div id="card-errors" role="alert" class="col-md-12 col-sm-12"></div>

            <!-- https://stackoverflow.com/questions/59138359/laravel-crud-decimal-change-dot-to-comma-in-the-form -->
            <button class="btn btn-success mt-5 w-100" id="submit">Pay Now (${{ number_format($grandAmount,2) }})</button>
        </form>
        <div class="error_msg">
            {{-- All errors will be displayed here... 내가 추가... --}}
        </div>
    </div>
    @endif
</div>
@endsection

@section('extra-js')

<script src="https://js.stripe.com/v3/"></script>
<script>
var stripe = Stripe("{{ env('STRIPE_PUB_KEY') }}");//take the stripe public key from .env file
var elements = stripe.elements();//make tripe elements
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
// var card = elements.create("card", { style: style, hidePostalCode: true });//hidePostalCode: true 내가추가...
var card = elements.create("card", { iconStyle: 'solid', style: style, hidePostalCode: true });//hidePostalCode: true, iconStyle: 'solid' 내가추가...
card.mount("#card-element");//show card layout

card.addEventListener('change', ({error}) => {//display errors when type card details
    const displayError = document.getElementById('card-errors');
    if (error) {
        displayError.classList.add('alert', 'alert-warning');
        displayError.textContent = error.message;
        $('.error_msg').html("").removeClass('alert').removeClass('alert-danger');////
    } else {
        displayError.classList.remove('alert', 'alert-warning');
        displayError.textContent = '';
        $('.error_msg').html("").removeClass('alert').removeClass('alert-danger');////
    }
});

var form = document.getElementById('payment-form');
var submitButton = document.getElementById('submit');////
var customerName = "{{ $userName }}"; //$userName => CheckoutController에서 받은 값

form.addEventListener('submit', function(ev) {//click Pay Now button
    ev.preventDefault();
    submitButton.disabled = true;////

    ////https://stackoverflow.com/questions/55093152/how-to-show-spinner-in-stripe-after-button-is-clicked
    ////my_loader ==> public/css/app.css(resources/sass/app.scss => compiled..)
    $('.loading_spiner').addClass('my_loader');//start loading spiner

    ////아래에서 카드 결제가 이루어 진다.
    stripe.confirmCardPayment("{{ $clientSecret }}", { //$clientSecret => CheckoutController에서 받은 값
        payment_method: {
            card: card,
            billing_details: {
                name: customerName ////
            }
        }
    })
    .then(function(result) {
        if (result.error) {
        // Show error to your customer (e.g., insufficient funds)
        submitButton.disabled = false;////

        // console.log(result.error.message);

        $('.loading_spiner').removeClass('my_loader');//stop loading spiner

        $('.error_msg').html("");////
        $('.error_msg').append(result.error.message).addClass('alert').addClass('alert-danger');////
        } else {
            // The payment has been processed!
            $('.error_msg').html("");////
            if (result.paymentIntent.status === 'succeeded') {
                // Show a success message to your customer
                // There's a risk of the customer closing the window before callback
                // execution. Set up a webhook or plugin to listen for the
                // payment_intent.succeeded event that handles any business critical
                // post-payment actions.

                ////for stripe ==> more detailes
                //////www.youtube.com/watch?v=HYk__gNN_D4&list=PLeeuvNW2FHVixxKWVXqhjH1_5CPQ7nffP&index=14

                // console.log(result.paymentIntent);

                // var paymentIntent = JSON.stringify({ 'paymentIntent': result.paymentIntent });

                var paymentIntent = JSON.stringify({ 'paymentIntent': result.paymentIntent,
                                                     'shippingCost': {{ $shippingCost }},
                                                     'addressee': '{{ $addressee }}',
                                                     'addressId': {{ $addressId }}
                                                    });

                $.ajax({ //결제 내용을 CheckoutController@payment 로 보내 저장한다.
                    type: "Post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('checkout.payment') }}",
                    cache: false,
                    data: paymentIntent,
                    success: function (data) {
                        //console.log(data);
                        if (data.errorMsg){
                            $('.error_msg').html("");
                            $('.error_msg').append(data.errorMsg).addClass('alert').addClass('alert-danger');
                            submitButton.disabled = false;////

                            $('.loading_spiner').removeClass('my_loader');//stop loading spiner

                        }else{
                            $('.error_msg').html("");
                            $('.error_msg').append(data.successMsg).removeClass('alert').removeClass('alert-danger');
                            $('.count_cart').text(data.countCart);

                            window.location.href = '/order/orderDetailsById' + '/' + data.orderId;

                            $('.loading_spiner').removeClass('my_loader');//stop loading spiner

                        }
                    },
                    error: function (error) {
                        console.log(error);
                        $('.error_msg').html("");////
                        $('.error_msg').append(error.statusText).addClass('alert').addClass('alert-danger');
                        submitButton.disabled = false;////

                        $('.loading_spiner').removeClass('my_loader');//stop loading spiner

                    }
                });
            }
        }
    })
    .catch(function(error) {
        console.log(error);
        $('.error_msg').html("");////
        $('.error_msg').append(error).addClass('alert').addClass('alert-danger');
        submitButton.disabled = false;////

        $('.loading_spiner').removeClass('my_loader');//stop loading spiner

    })
});
</script>

@endsection
