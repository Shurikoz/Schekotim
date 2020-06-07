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
    var number = $(e.target).data('number');
    if ($('#openNewWindow').is(':checked')) {
        window.open("/card/view?number=" + number);
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

//************************************************************************
//функция проверки существует ли пациент по введенным ФИО
function checkCard() {
    let checkCard = $("#checkCard");
    let n = $('#name').val();
    let mn = $('#middle_name').val();
    let bd = $('#birthday').val();
    if (bd.length > 0 && n.length > 0 && mn.length > 0){
        // console.log(true);
        $.ajax({
            url: "/card/check-card?n=" + n + "&mn=" + mn + "&bd=" + bd,
            cache: false,
            data: {},
            method: "POST",
            beforeSend: function () {
                checkCard.html('');
            }
        }).done(function (data) {
            if (data != '') {
                checkCard.append('<hr><b><span class="glyphicon glyphicon-exclamation-sign"></span> Найдены совпадения имён:</b><br>');
                $.each(data, function(index, val) {
                    let i = '<div style="margin-left: 15px; padding: 5px">';
                    i += ' ' + data[index].surname + ' <b>' + data[index].name + ' ' + data[index].middle_name + ', ' + data[index].birthday + '</b>, Карта #' + data[index].number + '; ';
                    i += ' <a href="/card/view?number=' + data[index].number + '" target="_blank"> Открыть карту в новом окне</a>';
                    i += '</div>';
                    checkCard.append(i);
                });
            } else {
                checkCard.html('');
                checkCard.html('<hr><span style="color: #7ba335">Совпадений имён не найдено</span>');
             }
        }).fail(function () {
            checkCard.html('');
            checkCard.html('<hr><span style="color: #7ba335">Ошибка загрузки данных!</span>');
        });
    }
}