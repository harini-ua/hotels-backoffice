jQuery(document).ready(function ($) {

    $('.languages-list-wrapper').each(function () {
        var $this = $(this);

        $('.dataTable').on('change', '.active-switch', function(e) {
            $.post($(this).data('action'));
        });
    });

});
