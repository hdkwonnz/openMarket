@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div id="my_loader">
        <!-- will be loading for spinner loader  -->
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
        <h4>Input Card Details</h4>
        {{-- <form id="payment-form" action="{{ route('checkout.payment') }}" method="POST" class="my-4 mt-5"> --}}
        <form id="payment-form" action="" method="POST" class="my-4 mt-5">
            @csrf
            <div id="card-element">
                <!-- Elements will create input elements here -->
            </div>

            <!-- We'll put the error messages in this element -->
            <div id="card-errors" role="alert"></div>

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
{{-- <script src="{{ asset('myJs/checkout/spiner.js') }}"></script> --}}
{{-- <script src='/node_modules/spin.js/spin.js'></script> --}}
<script>

import {Spinner} from '/node_modules/spin.js';



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



    var opts = {
        lines: 13, // The number of lines to draw
        length: 38, // The length of each line
        width: 17, // The line thickness
        radius: 45, // The radius of the inner circle
        scale: 1, // Scales overall size of the spinner
        corners: 1, // Corner roundness (0..1)
        color: '#ffffff', // CSS color or array of colors
        fadeColor: 'transparent', // CSS color or array of colors
        speed: 1, // Rounds per second
        rotate: 0, // The rotation offset
        animation: 'spinner-line-fade-quick', // The CSS animation name for the lines
        direction: 1, // 1: clockwise, -1: counterclockwise
        zIndex: 2e9, // The z-index (defaults to 2000000000)
        className: 'spinner', // The CSS class to assign to the spinner
        top: '50%', // Top position relative to parent
        left: '50%', // Left position relative to parent
        shadow: '0 0 1px transparent', // Box-shadow for the lines
        position: 'absolute' // Element positioning
    };
    var target = document.getElementById('my_loader');
    var spinner = new Spinner(opts).spin(target);






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

                var paymentIntent = JSON.stringify({ 'paymentIntent': result.paymentIntent})

                $.ajax({ //결제 내용을 CheckoutController@payment 로 보내 저장한다.
                    type: "Post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('checkout.payment') }}",
                    cache: false,
                    data: paymentIntent,
                    success: function (data) {
                        if (data.errorMsg){
                            $('.error_msg').html("");
                            $('.error_msg').append(data.errorMsg).addClass('alert').addClass('alert-danger');
                            submitButton.disabled = false;////
                        }else{
                            // $('.error_msg').html("");
                            // $('.error_msg').append(data.successMsg).removeClass('alert').removeClass('alert-danger');
                            // $('.count_cart').text(data.countCart);
                            window.location.href = '/order/orderDetailsById' + '/' + data.orderId;
                        }
                    },
                    error: function (data) {
                        console.log(data);
                        $('.error_msg').html("");////
                        $('.error_msg').append(error).addClass('alert').addClass('alert-danger');
                        submitButton.disabled = false;////
                    }
                });
            }
        }
    });
});
</script>

@endsection
