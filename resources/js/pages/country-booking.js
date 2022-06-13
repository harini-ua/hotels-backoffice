jQuery(document).ready(function ($) {

    $('.country-booking-list-datatable').each(function () {
        var $this = $(this);

        const dateFilter = $(".date-filter");
        const route = dateFilter.attr('data-url') ? dateFilter.attr('data-url') : location.href;

        var form = {
            company: $this.find('#company'),
            country: $this.find('#country_id'),
            city: $this.find('#city_id'),
            hotel: $this.find('#hotel'),
            status: $this.find('#status'),
            platform_type: $this.find('#platform_type'),
            platform_version: $this.find('#platform_version'),
            date_type: $this.find('#date_type'),
            period: $this.find('#period'),
            submit: $this.find('#submit-btn'),
        }

        const period = form.period.datepicker({
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

        period.data('datepicker').selectDate(
            subtractMonths(1).format("dd/mm/yyyy") + ' - ' + (new Date()).format("dd/mm/yyyy")
        )

        function subtractMonths(numOfMonths, date = new Date()) {
            date.setMonth(date.getMonth() - numOfMonths);
            return date;
        }

        $(document).on('periodChange', function(e) {
            const date = e.value.split(" - ");
            if (date.length === 2) {
                //
            }
        });

        form.submit.on('click', (e) => {
            e.preventDefault();

            filters.set(form.company.attr('name'), form.company.find(':selected').val());
            filters.set(form.country.attr('name'), form.country.find(':selected').val());
            filters.set(form.city.attr('name'), form.city.find(':selected').val());
            filters.set(form.hotel.attr('name'), form.hotel.find(':selected').val());
            filters.set(form.status.attr('name'), form.status.find(':selected').val());
            filters.set(form.platform_type.attr('name'), form.platform_type.find(':selected').val());
            filters.set(form.platform_version.attr('name'), form.platform_version.find(':selected').val());
            filters.set(form.date_type.attr('name'), form.date_type.find(':selected').val());
            filters.set(form.period.attr('name'), form.period.val());

            if (form.period.val()) {
                const table = $('#' + form.submit.attr('data-table')).DataTable();
                let url = form.submit.attr('data-url');
                table.ajax.url(filters.url(url)).load();
            } else {
                swal('Oops!', 'Select a period of data to search', 'error');
            }
        });
    });

});
