"use strict";
//фенкция для скрытия оповещений через 5 сек
window.setTimeout(function () {
    $(".alert-success, .alert-danger, .alert-info, .alert-error ").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
    });
}, 10000);
//************************************************************************
//функция для автопоиска после изменения инпута
$(".autoSearchSubmit").change(function () {
    this.form.submit();
});
//************************************************************************
//сброс формы поиска
$(".resetFormButton").click(function () {
    $(".autoSearchSubmit").val('');
    this.form.submit();
});
//************************************************************************
//функция для соткрытия/скрытия информации о визитах
$(document).on('click', 'tr.visitBox', function (e) {
    var a = $(e.target).closest('tr.visitBox');
    a.toggleClass('activeBox');
    $('tr.visitBox').not(a).removeClass('activeBox');

    var b = $(e.target).closest('tr.visitBox').next('tr');
    b.toggleClass('hide');
    $('tr.visitInfoBlock').not(b).addClass('hide');
});
//************************************************************************
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
//************************************************************************
//функция для получения адресов точек в выбранном городе для создания нового пользователя

//функция для формы создания пользователя
$("#signupuser-city").on('change', function () {
    let element = "signupuser-address_point";
    let value = $(this).val();
    let data = [];
    let select = document.getElementById(element);
    $.ajax({
        url: "/site/get-address-point?id=" + value,
        cache: false,
        data: data,
        method: "POST",
        dataType: "json",
        beforeSend: function () {
            $("#errorData").removeClass('textRed').addClass('errorData').html('');
        }
    }).done(function (data) {
        select.options[0] = new Option("", "0");
        data.forEach(function (item, i, data) {
            select.options[i + 1] = new Option(item.address_point, item.id);
        });
        $("#errorData").removeClass('textRed errorData').html('');
    }).fail(function () {
        $("#errorData").removeClass('errorData').addClass('text-red').html('Ошибка загрузки данных!');
    });
});
//функция для создания карты администратором
$("#card-city").on('change', function () {
    let element = "card-address_point";
    let value = $(this).val();
    let data = [];
    let select = document.getElementById(element);
    select.innerHTML = '';
    $.ajax({
        url: "/site/get-address-point?id=" + value,
        cache: false,
        data: data,
        method: "POST",
        dataType: "json",
        beforeSend: function () {
            $("#errorData").removeClass('textRed').addClass('errorData').html('');
        }
    }).done(function (data) {
        select.options[0] = new Option("", "0");
        data.forEach(function (item, i, data) {
            select.options[i + 1] = new Option(item.address_point, item.id);
            // select.options[i + 1].setAttribute("data-id", item.id);
        });
        $("#errorData").removeClass('textRed errorData').html('');
    }).fail(function () {
        $("#errorData").removeClass('errorData').addClass('text-red').html('Ошибка загрузки данных!');
    });
});
//************************************************************************
// $("#card-address_point").on('change', function () {
//     let element = "visit-podolog_id";
//     let value = $('#card-address_point option:selected').attr('data-id') ;
//     let data = [];
//     let select = document.getElementById(element);
//     select.innerHTML = '';
//     $.ajax({
//         url: "/card/get-podolog?id=" + value,
//         cache: false,
//         data: data,
//         method: "POST",
//         dataType: "json",
//         beforeSend: function () {
//             $("#errorDataPod").removeClass('textRed').addClass('errorData').html('');
//         }
//     }).done(function (data) {
//         select.options[0] = new Option("", "0");
//         data.forEach(function (item, i, data) {
//             select.options[i + 1] = new Option(item.name, i + 1);
//         });
//         $("#errorDataPod").removeClass('textRed errorData').html('');
//     }).fail(function () {
//         $("#errorDataPod").removeClass('errorData').addClass('text-red').html('Ошибка загрузки данных!');
//     });
// });

//************************************************************************
//функция открывать в новом окне
$(document).on('click', '.linkNewWindow', function (e) {
    var id = $(e.target).data('id');
    if ($('#openNewWindow').is(':checked')) {
        window.open("/card/view?id=" + id);
        return false;
    }
});
//************************************************************************
//показать/скрыть информацию в фотографиях работ для SEO
$('.infoHiddenBlockBtn').on('click',function(e){
    let a = e.target.getAttribute('data-id');
    if ($(this).html() == 'Показать информацию <span class="glyphicon glyphicon-arrow-down"></span>') {
        $(this).html('Скрыть информацию <span class="glyphicon glyphicon-arrow-up"></span>');
    } else {
        $(this).html('Показать информацию <span class="glyphicon glyphicon-arrow-down"></span>');
    }
    $('.infoHiddenBlock' + a).slideToggle(300);
});