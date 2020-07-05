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
card.mount("#card-element");//show input card layout

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
                        }else{
                            $('.error_msg').html("");
                            $('.error_msg').append(data.successMsg).removeClass('alert').removeClass('alert-danger');
                            $('.count_cart').text(data.countCart);
                            // window.location.href = '/order/orderDetailsById' + '/' + data.orderId;
                        }
                    },
                    error: function (data) {
                        console.log(data);
                        $('.error_msg').html("");////
                        $('.error_msg').append(error).addClass('alert').addClass('alert-danger');
                    }
                });

                // var paymentIntent = result.paymentIntent;
                // var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                // var url = form.action;
                // fetch( //결제 내용을 CheckoutController@payment 로 보내 저장한다.
                //     url,
                //     {
                //         headers: {
                //             "Content-Type": "application/json",
                //             "Accept": "application/json, text-plain, */*",
                //             "X-Requested-With": "XMLHttpRequest",
                //             "X-CSRF-TOKEN": token
                //         },
                //         method: 'post',
                //         body: JSON.stringify({
                //             paymentIntent: paymentIntent
                //         })
                //     }
                // ).then((data) => {
                //     // console.log(data);
                //     ////for stripe ==> more detailes
                //     ////www.youtube.com/watch?v=HYk__gNN_D4&list=PLeeuvNW2FHVixxKWVXqhjH1_5CPQ7nffP&index=14
                //     if (data.status === 400) {
                //         var redirect = '/boutique';
                //        else {
                //         var redirect = '/mercy';
                //     }
                // }).catch((error) => {
                //     console.log(error)
                //     $('.error_msg').html("");////
                //     $('.error_msg').append(error).addClass('alert').addClass('alert-danger');////
                // })
            }
        }
    });
});
