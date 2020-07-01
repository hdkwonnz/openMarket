$(document).ready(function(){
    //// qty control => plus minus sign
    //// https://bootsnipp.com/snippets/2eKOz
    $('.qty_real').val(1);////set 1 for initial value

    $('.count').prop('disabled', true);
       $(document).on('click','.plus',function(){
        $('.count').val(parseInt($('.count').val()) + 1 );
        if ($('.count').val() > 99){ ////maximum is 99
            $('.count').val(1);
        }
        $('.qty_real').val(parseInt($('.count').val()));////passing real input value to input name='qty'
    });

    $(document).on('click','.minus',function(){
        $('.count').val(parseInt($('.count').val()) - 1 );
            if ($('.count').val() == 0) {
                $('.count').val(1);
            }
            $('.qty_real').val(parseInt($('.count').val()));////passing real input value to input name='qty'
        });
 });
