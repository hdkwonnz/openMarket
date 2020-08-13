$('.watched_products').click(function(){
    if (($('.delete_watched').length) == 0){
        alert("You do not have recently viewed items.");
        return;
    }
    $('.show_watched').toggle();
})

$('.delete_watched').each(function(i){
    $(this).click(function(){
        var savedProduct = $('.show_watched').eq(i); //현재 마우스온 상태인 상품을 세이브한다
        deleteRecall($('.product_id').eq(i).val(), savedProduct);
    })
})

function deleteRecall(productId,savedProduct){
    //var myCookie = 'myProducts' + '[' + productId + ']';
    //alert(myCookie);
    //document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    //alert(myCookie + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;");
    //document.cookie = myCookie + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

    $.ajax({
        url: "/home/deletCookieProduct",
        type: 'Post',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { id: productId },
        success: function (data) {
            $(savedProduct).empty();
            if (($('.delete_watched').length) == 0){
                $('.show_watched').hide();
            }
        },
        error: function (data) {

        }
    });
}
