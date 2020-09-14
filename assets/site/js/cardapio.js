$(function() {
    $("input[name=layout]").on('change', () => {
        var target = $("#temas");
        $('html, body').animate({
                scrollTop: target.offset().top
            },
            500,
            function () {
                // Callback after animation
                // Must change focus!
                var $target = $(target);
                $target.focus();
                if ($target.is(":focus")) { // Checking if the target was focused
                    return false;
                } else {
                    $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
                    $target.focus(); // Set focus again
                };
            });
    });
    $("input[name=tema]").on('change', () => {
        var target = $("#opcoes");
        $('html, body').animate({
                scrollTop: target.offset().top
            },
            500,
            function () {
                // Callback after animation
                // Must change focus!
                var $target = $(target);
                $target.focus();
                if ($target.is(":focus")) { // Checking if the target was focused
                    return false;
                } else {
                    $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
                    $target.focus(); // Set focus again
                };
            });
    });
});