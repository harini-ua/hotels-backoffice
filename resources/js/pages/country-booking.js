jQuery(document).ready(function ($) {

    $('.country-booking-list-datatable').each(function () {
        var $this = $(this);

        $( ".collapse-filters").trigger( "click" );

        var filters = {
            period: $this.find('#period'),
        }

        filters.period.datepicker({
            language: 'en',
            dateFormat: 'dd/mm/yyyy',
            range: true,
            autoClose: true,
            maxDate: new Date(),
            extraClass: 'date-range-picker',
            multipleDatesSeparator: ' - ',
            onSelect: function(value, date) {
                $(document).trigger({
                    type: 'periodFirstChange',
                    value: value
                });
            }
        });

        $(document).on('periodFirstChange', function(e) {
            const date = e.value.split(" - ");
            if (date.length === 2) {
                //
            }
        });
    });

});
