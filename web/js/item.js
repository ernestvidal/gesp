
$(document).ready(function () {
    // Implementa autoresize vertical en textarea.

    $('textarea').each(function () {
        var offset = this.offsetHeight - this.clientHeight;
                var resizeTextarea = function (el) {
                        jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
                    };
                jQuery(this).on('keyup input', function () {
            resizeTextarea(this);
        }).removeAttr('data-autoresize');
    });

});


