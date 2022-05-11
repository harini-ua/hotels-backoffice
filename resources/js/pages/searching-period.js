jQuery(document).ready(function ($) {

    $('.searching-period-list-wrapper').each(function () {
        var $this = $(this);

        $('#period-first').datepicker({
            language: 'en',
            dateFormat: 'dd/mm/yyyy',
            range: true,
            maxDate: new Date(),
            multipleDatesSeparator: ' - ',
        });

        $('#period-second').datepicker({
            language: 'en',
            dateFormat: 'dd/mm/yyyy',
            range: true,
            maxDate: new Date(),
            multipleDatesSeparator: ' - ',
        });
    });

});
