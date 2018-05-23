$(document).ready(function () {
    $('#emoji-bar').click(function () {

        $(this).fadeToggle(1000);

        $(this).mouseout(function () {
            $(this).css("Display","Hidden");
        });

    });
});