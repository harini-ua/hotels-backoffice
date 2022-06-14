jQuery(document).ready(function ($) {

    $('.report-booking-customer-list-datatable').each(function () {
        const $this = $(this);

        const forms = {
            quick: {
                booking_type: $this.find('#booking_type'),
                company: $this.find('#company'),
                check_in: $this.find('#check_in'),
                submit: $this.find('#quick-submit-btn'),
            },
            advanced: {
                booking_type: $this.find('#booking_type'),
                order_id: $this.find('#order_id'),
                booking_id: $this.find('#booking_id'),
                booking_status: $this.find('#status'),
                giftcard: $this.find('#giftcard'),
                guest_name: $this.find('#guest_name'),
                guest_email: $this.find('#guest_email'),
                date_type: $this.find('#date_type'),
                period: $this.find('#period'),
                submit: $this.find('#advanced-submit-btn'),
            }
        };

        forms.quick.check_in.datepicker({
            language: 'en',
            dateFormat: 'dd/mm/yyyy',
            range: true,
            autoClose: true,
            maxDate: new Date(),
            extraClass: 'date-range-picker',
            multipleDatesSeparator: ' - ',
            onSelect: function(value, date) {
                $(document).trigger({
                    type: 'periodCheckInChange',
                    value: value
                });
            }
        });

        forms.advanced.period.datepicker({
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
            if (date.length === 2) {
                //
            }
        });

        $(document).on('periodVoucherDateChange', function(e) {
            const date = e.value.split(" - ");
            if (date.length === 2) {
                //
            }
        });

        forms.quick.submit.on('click', (e) => {
            e.preventDefault();

            filters.set(forms.quick.booking_type.attr('name'), forms.quick.booking_type.find(':selected').val());
            filters.set(forms.quick.company.attr('name'), forms.quick.company.find(':selected').val());
            filters.set(forms.quick.check_in.attr('name'), forms.quick.check_in.val());
            filters.set(forms.quick.submit.attr('name'), true);

            if (forms.quick.check_in.val()) {
                const table = $('#' + forms.quick.submit.attr('data-table')).DataTable();
                let url = forms.quick.submit.attr('data-url');
                table.ajax.url(filters.url(url)).load();
            } else {
                swal('Oops!', 'Select a check in period of data to search', 'error');
            }
        });

        forms.advanced.submit.on('click', (e) => {
            e.preventDefault();

            filters.set(forms.advanced.order_id.attr('name'), forms.advanced.order_id.find(':selected').val());
            filters.set(forms.advanced.booking_id.attr('name'), forms.advanced.booking_id.find(':selected').val());
            filters.set(forms.advanced.voucher_date.attr('name'), forms.advanced.voucher_date.val());
            filters.set(forms.advanced.submit.attr('name'), true);

            if (forms.advanced.voucher_date.val()) {
                const table = $('#' + forms.advanced.submit.attr('data-table')).DataTable();
                let url = forms.advanced.submit.attr('data-url');
                table.ajax.url(filters.url(url)).load();
            } else {
                swal('Oops!', 'Select date period to search', 'error');
            }
        });
    });

});
