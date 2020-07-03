@extends('layouts.app')

@section('content')

<div class="container mt-5"> <!-- 추후 수정 할것...  -->
    @if ($errorMsg)
        <div class="row no-gutters">
            <div class="col-md-12 col-sm-12">
                <div class="text-danger">
                    <h4>{{ $errorMsg }}</h4>
                </div>
            </div>
        </div>
    @else
    <div class="col-md-6 col-sm-6" style="margin-top: 100px; margin-bottom: 100px;">
        <h4>Input Card Details</h4>
    <form id="payment-form" action="{{ route('checkout.payment') }}" method="POST" class="my-4 mt-5">
            @csrf
            <div id="card-element">
                <!-- Elements will create input elements here -->
            </div>

            <!-- We'll put the error messages in this element -->
            <div id="card-errors" role="alert"></div>

            <button class="btn btn-success mt-5 w-100" id="submit">Pay Now</button>
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
////https://stripe.com/nz/payments/elements ==> 혹시 참고될까 하여...
////https://stripe.dev/elements-examples/ ==> 혹시 참고될까 하여...
////https://stripe.com/docs/testing ==> test card
////https://stripe.com/nz/payments/features#smart-payment-page ==> nz srtipe
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
// var card = elements.create("card", { style: style, hidePostalCode: true });//hidePostalCode: true 내가추가...
var card = elements.create("card", { iconStyle: 'solid', style: style, hidePostalCode: true });//hidePostalCode: true, iconStyle: 'solid' 내가추가...
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
var customerName = "{{ $userName }}"; //$userName => CheckoutController에서 받은 값

form.addEventListener('submit', function(ev) {
    ev.preventDefault();
    submitButton.disabled = true;////

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

        console.log(result.error.message);

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

                // console.log(result.paymentIntent);

                var paymentIntent = result.paymentIntent;
                var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                var url = form.action;
                var redirect = '/mercy'; ////추후에 바꿀 것

                fetch(
                    url,
                    {
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, text-plain, */*",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": token
                        },
                        method: 'post',
                        body: JSON.stringify({
                            paymentIntent: paymentIntent
                        })
                    }
                ).then((data) => {

                    ////추후에 아래처럼 바꿀 것 CheckoutController@store를 먼저 고친 후에...
                    //// www.youtube.com/watch?v=HYk__gNN_D4&list=PLeeuvNW2FHVixxKWVXqhjH1_5CPQ7nffP&index=14
                    // if (data.status === 400) {
                    //     var redirect = '/boutique';
                    // } else {
                    //     var redirect = '/mercy';
                    // }

                    // console.log(data)

                    $('.count_cart').text(0);

                    //window.location.href = redirect;////
                    alert("good....");////////////////////////////////////

                }).catch((error) => {
                    console.log(error)
                })
            }
        }
    });
});
</script>

@endsection
