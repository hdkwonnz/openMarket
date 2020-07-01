////handling modal
////쿠키를 체크한다.https://www.youtube.com/watch?v=6jJapEzFW0A
////cookie 이름 : close
////cookie 값 : yes
if(GetCookie("close") == "yes"){ // 화면 로딩 시에 close cookie 값이 yes이면,
    // 모달을 열지 않는다.
}else{
    // 아니라면 모달을 열어줍니다.
    $('.noticeModal-modal-xl').modal('show'); //The class of the modal to show
}
// 모달을 닿을때
$(".modal").on("hidden.bs.modal", function(){//when modal gets closed
    // alert("modal closed...");
    if($("input[name=todayClose]").is(":checked")){ // 체크박스가 선택되어 있다면,
        setCookie("close", "yes", 1); // close cookie를 yes 값으로 저장합니다.
        // cookie 이름 : close
        // cookie 값 : yes
    }
});

function setCookie(name, value, expiredays){
    var days=expiredays;
    if(days){
        var date=new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires="; expires="+date.toGMTString();
    }else{
        var expires="";
    }
    document.cookie=name+"="+value+expires+"; path=/";
}
function GetCookie(name){
    var value=null, search=name+"=";
    if(document.cookie.length > 0){
        var offset=document.cookie.indexOf(search);
        if(offset != -1){
            offset+=search.length;
            var end=document.cookie.indexOf(";", offset);
            if(end == -1) end=document.cookie.length;
            value=unescape(document.cookie.substring(offset, end));
        }
    } return value;
}

////hadling category menu
$('.category_com01').mouseover(function(){
    $(this).addClass('bg-white').addClass('text-dark');
    $('.categorya_name01').addClass('bg-white').addClass('text-dark');
    $('.category_sub01').show().addClass('bg-white').addClass('text-dark').addClass('z_index2');
})
$('.category_com01').mouseout(function(){
    $(this).removeClass('bg-white').removeClass('text-dark').addClass('bg-primary').addClass('text-white');
    $('.categorya_name01').removeClass('bg-white').removeClass('text-dark').addClass('bg-primary').addClass('text-white');
    $('.category_sub01').hide();
});

$('.category_com02').mouseover(function(){
    $(this).addClass('bg-white').addClass('text-dark');
    $('.categorya_name02').addClass('bg-white').addClass('text-dark');
    $('.category_sub02').show().addClass('bg-white').addClass('text-dark').addClass('z_index2');
})
$('.category_com02').mouseout(function(){
    $(this).removeClass('bg-white').removeClass('text-dark').addClass('bg-primary').addClass('text-white');
    $('.categorya_name02').removeClass('bg-white').removeClass('text-dark').addClass('bg-primary').addClass('text-white');
    $('.category_sub02').hide();
});
