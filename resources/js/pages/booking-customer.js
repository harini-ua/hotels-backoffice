jQuery(document).ready(function ($) {

    $('.report-booking-customer-list-datatable').each(function () {
        const $this = $(this);

        const forms = {
            quick: {
                booking_type: $this.find('#booking_type'),
                status: $this.find('#status'),
                company: $this.find('#company'),
                check_in: $this.find('#check_in'),
                submit: $this.find('#quick-submit-btn'),
            },
            advanced: {
                booking_type: $this.find('#booking_type'),
                order_id: $this.find('#order_id'),
                booking_id: $this.find('#booking_id'),
                status: $this.find('#status'),
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
            filters.set(forms.quick.status.attr('name'), forms.quick.status.find(':selected').val());
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

            filters.set(forms.advanced.booking_type.attr('name'), forms.advanced.booking_type.find(':selected').val());
            filters.set(forms.advanced.order_id.attr('name'), forms.advanced.order_id.val());
            filters.set(forms.advanced.booking_id.attr('name'), forms.advanced.booking_id.val());
            filters.set(forms.advanced.status.attr('name'), forms.advanced.status.find(':selected').val());
            filters.set(forms.advanced.giftcard.attr('name'), forms.advanced.giftcard.val());
            filters.set(forms.advanced.guest_name.attr('name'), forms.advanced.guest_name.val());
            filters.set(forms.advanced.guest_email.attr('name'), forms.advanced.guest_email.val());
            filters.set(forms.advanced.date_type.attr('name'), forms.advanced.date_type.find(':selected').val());
            filters.set(forms.advanced.period.attr('name'), forms.advanced.period.val());
            filters.set(forms.advanced.submit.attr('name'), true);

            if (forms.advanced.period.val()) {
                const table = $('#' + forms.advanced.submit.attr('data-table')).DataTable();
                let url = forms.advanced.submit.attr('data-url');
                table.ajax.url(filters.url(url)).load();
            } else {
                swal('Oops!', 'Select date period to search', 'error');
            }
        });

        $('.dataTable').on('click', '.payment-link', function(e) {
            e.preventDefault();

            var $this = $(this);

            swal({
                title: 'Payment?',
                text: 'Booking will be id!',
                type: 'success',
                showCancelButton: true,
                confirmButtonText: 'Yes, payment!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url      : $(this).data('payment'),
                        type     : 'POST',
                        dataType : 'json',
                        data     : { _method: 'POST' },
                        success  : function(response) {
                            if (response.success === true) {
                                var dataTable = $('.dataTable').DataTable();
                                var row = $this.parents('tr');

                                if ($(row).hasClass('child')) {
                                    dataTable.row($(row).prev('tr')).remove().draw();
                                } else {
                                    dataTable.row($(this).parents('tr')).remove().draw();
                                }
                            }
                            swal({
                                title : response.success === false ? 'Error!' : 'Successfully!',
                                text  : response.message,
                                type  : response.success === false ? 'error' : 'success',
                            }).then((value) => {});
                        },
                        error    : function(data) {
                            swal('Error!', 'Booking has not been paid!', 'error');
                        }
                    }).always(function (data) {
                        $('#clients-list-datatable').DataTable().draw(false);
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    return false;
                }
            })
        })

        $('.dataTable').on('click', '.send-link', function(e) {
            e.preventDefault();

            var $this = $(this);
        })
    });

});
