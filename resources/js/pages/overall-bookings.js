jQuery(document).ready(function ($) {

    $('.overall-bookings-list-wrapper').each(function () {
        var $this = $(this);

        var table = $this.find('#overall-bookings-list-datatable')

        table.find('thead').prepend('<tr>\n' +
            '    <th colspan="4" rowspan="2" class="border-right"></th>\n' +
            '    <th colspan="8" class="text-center border-right">Current Year</th>\n' +
            '    <th colspan="8" class="text-center">Previous Year</th>\n' +
            '</tr>\n' +
            '<tr>\n' +
            '    <th colspan="2" class="text-center">Today</th>\n' +
            '    <th colspan="2" class="text-center">This Week</th>\n' +
            '    <th colspan="2" class="text-center">This Month</th>\n' +
            '    <th colspan="2" class="text-center border-right">This Year</th>\n' +
            '    <th colspan="2" class="text-center">Same Day</th>\n' +
            '    <th colspan="2" class="text-center">Same Week</th>\n' +
            '    <th colspan="2" class="text-center">Same Month</th>\n' +
            '    <th colspan="2" class="text-center ">Same Year</th>\n' +
            '</tr>')
    });

});
