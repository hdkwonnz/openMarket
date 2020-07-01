////just for example. not used.
$('.orderdetail_by_term').on('submit',function(event) {
    event.preventDefault();
    alert("hehe...");
    fromDate = $('.from_date').val();
    toDate = $('.to_date').val();

    if ( fromDate > toDate){
        alert('Selected date error.');
        return;
    }

    $.ajax({
        url: "/order/orderDetailsByTerm",
        type:"get",
        data:{
            fromDate: fromDate,
            toDate: toDate
        },
        success:function(response){
            //console.log(response);
            $('.order_details_latest').empty().append(response);
        },
        error: function (data) {
            console.log(data);
            alert("Woops! system error on orderDetailsByTerm.")
            //debugger;
        }
    });
});
