"use strict";
//фенкция для скрытия оповещений через 5 сек
window.setTimeout(function () {
    $(".alert-success, .alert-danger, .alert-info, .alert-error ").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
    });
}, 10000);

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

//функция открывать в новом окне
$(document).on('click', '.linkNewWindow', function (e) {
    var id = $(e.target).data('id');
    if ($('#openNewWindow').is(':checked')) {
        window.open("/card/view?id=" + id);
        return false;
    }
});

//показать/скрыть информацию в фотографиях работ для SEO
$('.infoHiddenBlockBtn').on('click',function(e){
    let a = e.target.getAttribute('data-id');
    $('.infoHiddenBlock' + a).slideToggle(300);
    if ($(this).html() == 'Показать информацию <span class="glyphicon glyphicon-arrow-down"></span>') {
        $(this).html('Скрыть информацию <span class="glyphicon glyphicon-arrow-up"></span>');
    } else {
        $(this).html('Показать информацию <span class="glyphicon glyphicon-arrow-down"></span>');
    }
});