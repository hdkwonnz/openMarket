// $('.click_pay').click(function(){
//     $.ajax({
//         type: "Post",
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         url: "/checkout/payment",
//         cache: false,
//         success: function (data) {
//             $('.count_cart').text(0);
//             if (data.errorMsg){
//                 alert(data.errorMsg);
//             }else{
//                 window.location.href = '/order/orderDetailsById' + '/' + data.orderId;
//             }
//         },
//         error: function (data) {
//             console.log(data);
//             alert("Woops...errors on checkOUt");
//         }
//     });
//     return false;
// })
