$('.click_pay').click(function(){
    var selectedAddress = $('.selected_address').text();

    if (selectedAddress == ""){
        alert("Please select delivery Address.")
    }else{
        window.location.href = "/checkout/payNow" + '/' + selectedAddress;
    }
})


