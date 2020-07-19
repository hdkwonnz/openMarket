$('.watched_products').click(function(){
    $('.show_watched').toggle();
})

$('.delete_watched').each(function(i){
    $(this).click(function(){
        var savedProduct = $('.show_watched').eq(i); //현재 마우스온 상태인 상품을 세이브한다

        deleteRecall($('.product_id').eq(i).val(), savedProduct);
    })
})

function deleteRecall(productId,savedProduct){
    $.ajax({
        url: "/home/deletCookieProduct",
        type: 'Post',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { id: productId },
        success: function (data) {
            $(savedProduct).empty().hide();
        },
        error: function (data) {

        }
    });
}
