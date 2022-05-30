jQuery(document).ready(function ($) {

    $('.ip-filter-list-datatable').each(function () {
        let $this = $(this);

        //..
    });

    $('.ip-filter-create-wrapper, .ip-filter-edit-wrapper').each(function () {
        let $this = $(this);

        const form = {
            ip: $this.find('#ip_address'),
            is_expiry: $this.find('#is_expiry'),
            expiry: $this.find('#expiry'),

            btn: {
                submit: $this.find('#submit-btn')
            }
        };

        form.ip.inputmask("ip");

        if (form.is_expiry.val() == 1) {
            form.expiry.closest('.form-group').show();
        }

        const expiry_value = form.expiry.val();

        const expiry_datepicker = form.expiry.datepicker({
            language: 'en',
            dateFormat: 'dd/mm/yyyy',
            minDate: new Date(),
            position: 'top left',
        });

        if (expiry_value) {
            let date = expiry_value.split('/');
            expiry_datepicker.data('datepicker').selectDate(new Date(date[2], date[1]-1, date[0]))
        }

        form.is_expiry.on('change', function () {
            if (this.checked) {
                form.expiry.closest('.form-group').show();;
            } else {
                form.expiry.closest('.form-group').hide();
            }
        });
    });

});
