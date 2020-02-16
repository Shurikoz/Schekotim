"use strict";
window.setTimeout(function () {
    $(".alert-success, .alert-error ").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
    });
}, 3000);