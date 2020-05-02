"use strict";

//Проигрывание видео-превью к статьям на главной странице
//Передаем в функцию id статьи
function videoPlay(i){
    let video = document.getElementById("video_" + i);
    let button = document.getElementById("play_" + i);
    if (video.paused) {
        video.play();
        button.style.display = "none";
    } else {
        video.pause();
        button.style.display = "block";
    }
}

//Автоматически скрываем алерты через 4 сек
window.setTimeout(function () {
    $(".alert-success,.alert-danger, .alert-error ").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
    });
}, 10000);



//Кнопка развернуть форму для отзыва
function showReviewForm(){
    $('#reviewForm').slideDown();
    $("#showReviewFormButton").fadeOut(300, function () {
        $("#hideReviewFormButton").fadeIn(300, 0);
    });


}
//Кнопка свернуть форму для отзыва
function hideReviewForm(){
    $('#reviewForm').slideUp();
    $("#hideReviewFormButton").fadeOut(300, function () {
        $("#showReviewFormButton").fadeIn(300, 0);
    });
}

//Плавный переход к якорной ссылке (галерея)
$("body").on('click', '[href*="#"]', function(e){
    let fixed_offset = 75;
    $('html,body').stop().animate({ scrollTop: $(this.hash).offset().top - fixed_offset }, 500);
    e.preventDefault();
});


jQuery(document).ready(function(){
    jQuery("#podolog").unitegallery();
    jQuery("#manicure").unitegallery();
    jQuery("#pedicure").unitegallery();
});

$(document).ready(function() {
    $('.image-review-link').magnificPopup({type:'image'});
});