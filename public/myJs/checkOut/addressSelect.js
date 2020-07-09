$(function(){
    $('.existing_contents').each(function(i){
        $(this).click(function(){
            $('.selected_address').empty().text(($(this).find('.existing_address').text()));
            $('.selected_address').css('font-weight','bold');
            $('.selected_addressee').empty().text(($(this).find('.existing_addressee').text()));
            $('.selected_addressee').css('font-weight','bold');
        })
    })

    $('#findAddress').on('submit',function(event){
        event.preventDefault();

        //apiKey="a88039a8124c4995a04f445d050de41a";
        apiKey="demo-api-key";
        streetName = $('.street_name').val();

        $.ajax({
            url: "https://api.addy.co.nz/search",
            type:"get",
            data:{
                key: apiKey,
                s: streetName
            },
            success:function(response){
                //console.log(response);
                $('.selected_address').empty();
                $('.address_section').empty();
                $.each(response.addresses, function(index, value){
                    //console.log(value.a);
                    $('.address_section').append('<tr><td style="width: 90%;" class="address_name">' + value.a + '</td>' +
                    '<td style="width: 10%;"><input type="radio" class="selectedValue" name="option" value="" /></td></tr>')
                })

                $('input[type="radio"]').each(function(i){
                    $(this).click(function(){
                        // console.log($(this).parents().find('.address_name').eq(i).text());
                        $('.selected_address').empty().append($(this).parents().find('.address_name').eq(i).text());
                        $('.selected_address').css('font-weight','bold');
                    })
                })
            },
            error: function (data) {
                //console.log(data.statusText);
            }
        });
    });
})
