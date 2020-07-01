$(function () {
    ////first options의 "Show Connections" button을 click 하면
    $('.select_firstOption').click(function() {
        ////check for first option
        var checkedRadio = $(".checkableGridFirst input:radio:checked").length;
        if (checkedRadio < 1){
            alert("Please, select first option.");
            return;
        }

        showConnections()
    })

    ////second options의 "select all"을 click 하면(전체선택)
    $(".selectAll").bind("click", function () {
        var ischecked = this.checked;
        $('.checkableGridSecond').find("input:checkbox").each(function () {
            this.checked = ischecked;
        });
        ////checked 된 갯수를 count
        var checked = $(".checkableGridSecond input:checkbox:checked").length;
        ////checked 된 checkbox 가 있으면 Connect/Disconnect button을 보여준다.
        if (checked > 0){
            $('.join_selected').each(function () {//'Connect' button show
                $(this).removeClass('invisible').addClass('visible');
            })
            $('.delete_selected').each(function () {//'Disconnect' button show
                $(this).removeClass('invisible').addClass('visible');
            })
        }else{
            $('.join_selected').each(function () {//'Connect' button hide
                $(this).removeClass('visible').addClass('invisible');
            })
            $('.delete_selected').each(function () {//'Disconnect' button hide
                $(this).removeClass('visible').addClass('invisible');
            })
        }
    });

    ////second options 각각의  행에 있는 체크박스를 선택(개별선택)
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
        ////checked 된 checkbox 가 있으면  "Connect/Disconnect" button을 보여준다
        if (checked > 0){
            $('.join_selected').each(function () {//'Connect' button show
                $(this).removeClass('invisible').addClass('visible');
            })
            $('.delete_selected').each(function () {//Disconnect' button show
                $(this).removeClass('invisible').addClass('visible');
            })
        }else{
            $('.join_selected').each(function () {//'Connect' button hide
                $(this).removeClass('visible').addClass('invisible');
            })
            $('.delete_selected').each(function () {//Disconnect' button hide
                $(this).removeClass('visible').addClass('invisible');
            })
        }
    });

    ////"Connect" button을 click 하면
    $('.join_selected').click(function() {
        ////check for first option
        var checkedRadio = $(".checkableGridFirst input:radio:checked").length;
        if (checkedRadio < 1){
            alert("Please, select first option.");
            return;
        }

        ////confirm message
        var message = "Do you want to connect selected item(s)?";
        var result = confirm(message);
        if (result == true) {
            saveProductOptions();
        }
    })

    ////"Disconnect" button을 click 하면
    $('.delete_selected').click(function() {
        ////check for first option
        var checkedRadio = $(".checkableGridFirst input:radio:checked").length;
        if (checkedRadio < 1){
            alert("Please, select first option.");
            return;
        }

        ////confirm message
        var message = "Do you want to disconnect selected item(s)?";
        var result = confirm(message);
        if (result == true) {
            deleteProductOptions();
        }
    })
})

function deleteProductOptions()
{
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
        url: "/seller/disConnectProductOptions",
        data: {secondOptionIds: arrayIds, firstOptionId: firstOptionId, productId: productId},
        cache: false,
        success: function (data) {
            //console.log(data);
            clearCheckBox();
            $('.result').html('').append(data);
        },
        error: function (data) {
            console.log(data);
            alert('Woops something wrong...');
        }
    });
    return false;
}

function showConnections() {
    ////get checked first option id
    var firstOptionId;
    $(".checkableGridFirst").find("input:radio:checked").each(function () {
        firstOptionId = $(this).val().trim();
    });

    var productId = "{{ $product->id }}";

    $.ajax({
        type: "get",
        url: "/seller/showOptionConnections",
        data: {firstOptionId: firstOptionId},
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
            clearCheckBox();
            $('.result').html('').append(data);
        },
        error: function (data) {
            console.log(data);
            alert('Woops something wrong...');
        }
    });
    return false;
}

function clearCheckBox(){
    $(function(){
        $(".checkableGridSecond").find("input:checkbox").each(function () {
                this.checked = false;
        });
        $('.selectAll').each(function () {//'Select All' 옆에있는 체크박스도 동시에 바꾸어준다.
                    this.checked = false;
        })
        $('.join_selected').each(function () {//'Connect' button hide
                $(this).removeClass('visible').addClass('invisible');
        })
        $('.delete_selected').each(function () {//'Disconnect' button hide
                $(this).removeClass('visible').addClass('invisible');
        })
    })
}
