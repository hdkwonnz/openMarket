////home page loading 과 동시에 categoryb 를 read 하여 전체 menu 에 보내준다.
$.ajax({
    type: "get",
    url: "/allCategory",
    cache: false,
    success: function (data) {
        //console.log(data);
        $('.all_category').html('').append(data);
    },
    error: function (data) {
        console.log(data);
        // alert('Woops something wrong...');
    }
});


// $('.all_menu').click(function(){
//     $('.all_category').toggle();
//     $('.cross_img').toggle();
// })

$(function(){
    var toggleSw = false;
    $('.all_menu').click(function(){
        if (toggleSw == false){
            $('.all_category').show();
            $('.bars_img').hide();
            $('.cross_img').show();
            toggleSw = true;
        }else{
            $('.all_category').hide();
            $('.bars_img').show();
            $('.cross_img').hide();
            toggleSw = false;
        }
    })
})
