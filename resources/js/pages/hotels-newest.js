jQuery(document).ready(function ($) {

    $('.hotels-newest-list-datatable').each(function () {
        var $this = $(this);

        $( ".collapse-filters").trigger( "click" );

        const dateFilter = $(".date-filter");

        var form = {
            period: $this.find('#period'),
        }

        const dataTable = form.period.attr('data-table');
        const route = form.period.attr('data-url');

        form.period.datepicker({
            language: 'en',
            dateFormat: 'dd/mm/yyyy',
            range: true,
            autoClose: true,
            maxDate: new Date(),
            extraClass: 'date-range-picker',
            multipleDatesSeparator: ' - ',
            onSelect: function(value, date) {
                $(document).trigger({
                    type: 'periodChange',
                    value: value
                });
            }
        });

        $(document).on('periodChange', function(e) {
            const date = e.value.split(" - ");
            console.log(0);
            if (date.length === 2) {
                filters.set(
                    form.period.attr('name'),
                    form.period.val()
                );

                console.log(1);

                const table = $('#' + dataTable).DataTable();
                console.log('#' + dataTable);
                table.ajax.url(filters.url(route)).load();
            }
        });
    });

});
