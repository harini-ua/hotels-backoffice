jQuery(document).ready(function ($) {

    $('.searching-period-list-wrapper').each(function () {
        var $this = $(this);

        const dateFilter = $(".date-filter");
        const route = dateFilter.attr('data-url') ? dateFilter.attr('data-url') : location.href;

        var form = {
            period_first: $this.find('#period-first'),
            period_second: $this.find('#period-second'),
        }
        var table = $this.find('#searching-period-list-datatable')

        form.period_first.datepicker({
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
                if (form.period_second.val()) {
                    let second = form.period_second.val()
                    const date = second.split(" - ")
                    if (date.length === 2) {
                        filters.set(
                            form.period_first.attr('name'),
                            form.period_first.val()
                        );
                        $('.first-period').text(form.period_first.val())

                        filters.set(
                            form.period_second.attr('name'),
                            form.period_second.val()
                        );
                        $('.second-period').text(form.period_second.val())

                        const table = $('#' + dateFilter.attr('data-table')).DataTable();
                        table.ajax.url(filters.url(route)).load();
                    } else {
                        form.period_second.focus()
                    }
                } else {
                    form.period_second.focus()
                }
            }
        });

        form.period_second.datepicker({
            language: 'en',
            dateFormat: 'dd/mm/yyyy',
            range: true,
            autoClose: true,
            maxDate: new Date(),
            extraClass: 'date-range-picker',
            multipleDatesSeparator: ' - ',
            onSelect: function(value, date) {
                $(document).trigger({
                    type: 'periodSecondChange',
                    value: value
                });
            }
        });

        $(document).on('periodSecondChange', function(e) {
            const date = e.value.split(" - ");
            if (date.length === 2) {
                if (form.period_first.val()) {
                    let first = form.period_first.val()
                    const date = first.split(" - ")
                    if (date.length === 2) {
                        filters.set(
                            form.period_first.attr('name'),
                            form.period_first.val()
                        );
                        $('.first-period').text(form.period_first.val())

                        filters.set(
                            form.period_second.attr('name'),
                            form.period_second.val()
                        );
                        $('.second-period').text(form.period_second.val())

                        const table = $('#' + dateFilter.attr('data-table')).DataTable();
                        table.ajax.url(filters.url(route)).load();
                    } else {
                        form.period_first.focus()
                    }
                } else {
                    form.period_first.focus()
                }
            }
        });

        table.find('thead').prepend('<tr>\n' +
            '    <th class="border-right"></th>\n' +
            '    <th colspan="2" class="text-center first-period border-right">First Period</th>\n' +
            '    <th colspan="2" class="text-center second-period">Second Period</th>\n' +
            '</tr>')
    });

});
