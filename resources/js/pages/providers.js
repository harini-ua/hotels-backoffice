jQuery(document).ready(function ($) {

    $('.providers-list-wrapper').each(function () {
        var $this = $(this);

        $('.dataTable').on('change', '.active-switch', function(e) {
            $.post($(this).data('action'));
        });
    });

});
