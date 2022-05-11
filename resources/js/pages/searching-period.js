jQuery(document).ready(function ($) {

    $('.searching-period-list-wrapper').each(function () {
        var $this = $(this);

        // https://longbill.github.io/jquery-date-range-picker/
        $('#period-first').datepicker({
            language: 'en',
            dateFormat: 'dd/mm/yyyy',
            range: true,
            autoClose: true,
            maxDate: new Date(),
            multipleDatesSeparator: ' - ',
        });

        // https://longbill.github.io/jquery-date-range-picker/
        $('#period-second').datepicker({
            language: 'en',
            dateFormat: 'dd/mm/yyyy',
            range: true,
            autoClose: true,
            maxDate: new Date(),
            multipleDatesSeparator: ' - ',
        });

        var table = $this.find('#searching-period-list-datatable')

        table.find('thead').prepend('<tr>\n' +
            '    <th class="border-right"></th>\n' +
            '    <th colspan="2" class="text-center border-right">First Period</th>\n' +
            '    <th colspan="2" class="text-center">Second Period</th>\n' +
            '</tr>')
    });

});
