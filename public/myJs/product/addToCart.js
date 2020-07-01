//// add to cart
$('.add_cart').on('submit',function(event){
    event.preventDefault();

    productId = $('.product_id').val().trim();
    productQty = $('.qty_real').val().trim();

    if ( productQty < 1){
        alert('Please enster qty.');
        return;
    }

    $.ajax({
        url: "/cart/addToCart",
        type:"get",
        data:{
            id: productId,
            qty: productQty
        },
        success:function(response){
            //console.log(response);
            if(response.errorMsg){
                alert(response.errorMsg);
            }else{
                $('.count_cart').empty().text(response.countOfItems);
                alert(response.successMsg);
            }
        },
        error: function (data) {
            console.log(data);
            alert("Woops! system error on adding to cart.")
            //debugger;
        }
    });
});
