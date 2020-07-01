$(function () {
    ////테이블 위에있는 체크박스(전체선택)
    $(".selectAll").bind("click", function () {
        var ischecked = this.checked;
        $('.checkableGridSecond').find("input:checkbox").each(function () {
            this.checked = ischecked;
        });
        ////checked 된 갯수를 count
        var checked = $(".checkableGridSecond input:checkbox:checked").length;
        ////checked 된 checkbox 가 있으면 save button을 보여준다.
        if (checked > 0){
            $('.join_selected').each(function () {//'Save To Join' button show
                $(this).removeClass('invisible').addClass('visible');
            })
        }else{
            $('.join_selected').each(function () {//'Save To Join' button hide
                $(this).removeClass('visible').addClass('invisible');
            })
        }
    });

    ////각각의  행에 있는 체크박스를 선택(개별선택)
    $("input[name='secondOptionId']").click(function () {
        ////total check box 수를 구한다.
        var totalRows = $(".secondOptionId").length;
        ////checked 된 갯 수를 구한다.
        var checked = $(".checkableGridSecond input:checkbox:checked").length;
        if (checked == totalRows) {
            $(".checkableGridSecond").find("input:checkbox").each(function () {
                this.checked = true;
                $('.selectAll').each(function () {//'Select All' 옆에있는 체크박스도 동시에 바꾸어준다.
                    this.checked = true;
                })
            });
        }
        else {
            $('.selectAll').each(function () {//'Select All' 옆에있는 체크박스도 동시에 바꾸어준다.
                this.checked = false;
            })
        }
        ////checked 된 checkbox 가 있으면  save button을 보여준다
        if (checked > 0){
            $('.join_selected').each(function () {//'Save To Join' button show
                $(this).removeClass('invisible').addClass('visible');
            })
        }else{
            $('.join_selected').each(function () {//'Save To Join' button hide
                $(this).removeClass('visible').addClass('invisible');
            })
        }
    });

    ////"Save To Join" button을 click 하면
    $('.join_selected').click(function() {
        ////check for first option
        var checkedRadio = $(".checkableGridFirst input:radio:checked").length;
        if (checkedRadio < 1){
            alert("Please, select first option.");
            return;
        }

        ////confirm message
        var message = "Do you want to save selected item(s)?";
        var result = confirm(message);
        if (result == true) {
            saveProductOptions();
        }
    })
})

function saveProductOptions() {
    ////get checked first option id
    var firstOptionId;
    $(".checkableGridFirst").find("input:radio:checked").each(function () {
        firstOptionId = $(this).val().trim();
    });

    ////get checked second option ids
    var arrayIds = [];
    $('.secondOptionId:checked').each(function () {
        var ids = $(this).val().trim();
        arrayIds.push(ids);
    });

    var productId = "{{ $product->id }}";

    $.ajax({
        type: "Post",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/seller/connectProductOptions",
        data: {secondOptionIds: arrayIds, firstOptionId: firstOptionId, productId: productId},
        cache: false,
        success: function (data) {
            //console.log(data);
            $('.result').html('').append(data);
        },
        error: function (data) {
            console.log(data);
            alert('Woops something wrong...');
        }
    });
    return false;
}
