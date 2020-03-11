"use strict";
window.setTimeout(function () {
    $(".alert-success, .alert-error ").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
    });
}, 3000);

$(".autoSearchSubmit").change(function() {
    this.form.submit();
});

$(".resetFormButton").click(function() {
    $(".autoSearchSubmit").val('');
    this.form.submit();
});

$(document).on('click', 'tr.visitBox', function (e) {
    var a = $(e.target).closest('tr.visitBox');
    a.toggleClass('activeBox');
    $('tr.visitBox').not(a).removeClass('activeBox');

    var b = $(e.target).closest('tr.visitBox').next('tr');
    b.toggleClass('hide');
    $('tr.visitInfoBlock').not(b).addClass('hide');
});

$( document ).ready(function() {
    var banner = $("#banner-message").find('p');
    var timerId = setInterval(function() {
        var now = new Date();
        var h = 24 - now.getHours();
        var m = 60 - now.getMinutes();
        var s = 60 - now.getSeconds();
        banner.text(h + ' : ' + m + " : " + s);
        if(h == 0 && m == 0 && s == 0){
            document.location.reload();
        }
    }, 1000);
});