"use strict";

//маска для ввода телефона в отзывах
jQuery(document).ready(function () {
    $("#reviewform-mobile").inputmask("+7(999)999-99-99");
});

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
}, 4000);

//Кнопка развернуть форму для отзыва
function showReviewForm(){
    $("#reviewForm").fadeIn(600, 0);
    $("#showReviewFormButton").fadeOut(300, function () {
        $("#hideReviewFormButton").fadeIn(300, 0);
    });
}
//Кнопка свернуть форму для отзыва
function hideReviewForm(){
    $("#reviewForm").fadeOut(600, 0);
    $("#hideReviewFormButton").fadeOut(300, function () {
        $("#showReviewFormButton").fadeIn(300, 0);
    });
}

