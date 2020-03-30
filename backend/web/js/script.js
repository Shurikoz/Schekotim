"use strict";
//фенкция для скрытия оповещений через 5 сек
window.setTimeout(function () {
    $(".alert-success, .alert-danger, .alert-info, .alert-error ").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
    });
}, 5000);

//функция для автопоиска после изменения инпута
$(".autoSearchSubmit").change(function () {
    this.form.submit();
});




//сброс формы поиска
$(".resetFormButton").click(function () {
    $(".autoSearchSubmit").val('');
    this.form.submit();
});

//функция для соткрытия/скрытия информации о визитах
$(document).on('click', 'tr.visitBox', function (e) {
    var a = $(e.target).closest('tr.visitBox');
    a.toggleClass('activeBox');
    $('tr.visitBox').not(a).removeClass('activeBox');

    var b = $(e.target).closest('tr.visitBox').next('tr');
    b.toggleClass('hide');
    $('tr.visitInfoBlock').not(b).addClass('hide');
});

//функция для загрузки "рыбы" при заполнении полей в создании посещения (visit/create)
$("#visit-problem_id").on('change', function () {
    let getValue = $(this).val();
    $.ajax({
        url: "/visit/receive?id=" + getValue,
        cache: false,
        data: {},
        method: "POST",
        beforeSend: function () {
            $("#errorData").removeClass('textRed').addClass('errorData').html('');
        }
    }).done(function (data) {
        if (data != null) {
            $("#visit-anamnes").val(data.anamnes);
            $("#visit-manipulation").val(data.manipulation);
            $("#visit-recommendation").val(data.recommendation);
        } else {
            $("#visit-anamnes").val('');
            $("#visit-manipulation").val('');
            $("#visit-recommendation").val('');
        }
        $("#errorData").removeClass('textRed errorData').html('');
    }).fail(function () {
        $("#errorData").removeClass('errorData').addClass('text-red').html('Ошибка загрузки данных!');
    });
});

//функция для автопоиска после изменения инпута
$("#submitFirstVisit").click(function () {
    $('.wrap').fadeTo(500, 0.2).addClass();
    $('body').append('<div class="loader"></div>');
});


// $(document).ready(function () {
//     $("#photo-onephotobefore").on('change', function () {
//         if (jQuery('#photo-onephotobefore').val()) {
//             $('.uploadBtnBefore').toggleClass('hidden');
//         }
//     });
//     $("#photo-onephotoafter").on('change', function () {
//         if (jQuery('#photo-onephotoafter').val()) {
//             $('.uploadBtnAfter').toggleClass('hidden');
//         }
//     });
// });


//отследим событие валидации формы, посчитав количество ошибок после валидации
//если = 0, то выполним код
// $("#addOnePhotoBefore").on("afterValidate", function (event, messages, errorAttributes) {
//     if (!errorAttributes.length) {
//             let visitId = $(this).attr('data-id');
//             let cardId = $(this).attr('data-card');
//             let photo = $("#photo-onephotobefore");
//             let fd = new FormData;
//             fd.append('img', photo.prop('files')[0]);
//             $.ajax({
//                 type: "POST",
//                 cache: false,
//                 processData: false,
//                 contentType: false,
//                 url: "/visit/add-photo?visitId=" + visitId + "&cardId=" + cardId,
//                 data: fd
//             }).done(function (data) {
//                 console.log(data);
//             }).fail(function () {
//                 console.log(false);
//             });
//     }
// });

// $('#photo-onephotobefore').click(function() {
//     alert( "Handler for .change() called." );
// });
