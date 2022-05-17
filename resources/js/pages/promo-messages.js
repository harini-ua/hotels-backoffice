"use strict";

$(document).ready(function ($) {

    $('.promo-messages-create-wrapper, .promo-messages-edit-wrapper').each(function () {
        var $this = $(this);

        const form = {
            expiry_date: $this.find('#expiry_date'),
            show_all_company: {
                select_all: $this.find('#select_all'),
                select_custom: $this.find('#select_custom'),
            },
            companies: $this.find('#company_ids'),
        };

        form.expiry_date.datepicker({
            language: 'en',
            dateFormat: 'dd/mm/yyyy',
            minDate: new Date(),
            position: 'top left',
            onSelect: function(value, date) {
                $(document).trigger({
                    type: 'expiryDateChange',
                    value: value
                });
            }
        });

        $(document).on('expiryDateChange', function(e) {
            console.log(e.value);
        });

        form.show_all_company.select_all.on('click', function() {
            form.companies.attr( 'disabled', true )
        })

        if (form.show_all_company.select_all.checked) {
            form.companies.attr( 'disabled', true )
        }

        form.show_all_company.select_custom.on('click', function() {
            form.companies.attr( 'disabled', false )
        })

        if (form.show_all_company.select_custom.checked) {
            form.companies.attr( 'disabled', false )
        }

        $('input.image-input').on('change', function() {
            const [file] = this.files;

            if (file) {
                $(this).closest('.form-group')
                    .find('img.preview')
                    .attr("src", URL.createObjectURL(file));
            }
        });
    });

});
