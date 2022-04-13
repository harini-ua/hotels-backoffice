jQuery(document).ready(function ($) {

    $('.discount-vouchers-create-wrapper, .discount-vouchers-edit-wrapper').each(function () {
        let $this = $(this);

        const form = {
            amount: $this.find('#amount'),
            min_price: $this.find('#min_price'),

            voucher_type: $this.find('#voucher_type'),
            voucher_codes_count: $this.find('#voucher_codes_count'),
            voucher_code: $this.find('#voucher_code'),

            expiry: $this.find('#expiry'),

            btn: {
                submit: $this.find('#submit-btn')
            }
        };

        form.amount.inputmask("decimal");
        form.min_price.inputmask("decimal");

        form.voucher_type.on('change', function() {
            changeVoucherType(this.value);
        });

        changeVoucherType(
            form.voucher_type.find('option').filter(':selected').val()
        );

        function changeVoucherType(value) {
            if (value == 0) {
                form.btn.submit.text('Generate');
                form.voucher_codes_count.parents('.row').removeClass('disabled');
                form.voucher_code.parents('.row').addClass('disabled');
            } else {
                form.btn.submit.text('Submit');
                form.voucher_codes_count.parents('.row').addClass('disabled');
                form.voucher_code.parents('.row').removeClass('disabled');
            }
        }

        form.expiry.datepicker({
            language: 'en',
            dateFormat: 'dd/mm/yyyy',
            minDate: new Date(),
            position: 'top left',
        });
    });

    $('.discount-vouchers-list-datatable').each(function () {
        let $this = $(this);

        //..
    });

});
