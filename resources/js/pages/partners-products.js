"use strict";

$(document).ready(function ($) {

    $('.partners-products-create-wrapper, .partners-products-edit-wrapper').each(function () {
        var $this = $(this);

        const form = {
            price_filter: $this.find('#price_filter'),
            price_filter_fields: $this.find('.price_filter_fields'),

            star_filter: $this.find('#star_filter'),
            star_filter_fields: $this.find('.star_filter_fields'),
        };

        if (form.price_filter.checked) {
            form.price_filter_fields.show();
        } else {
            form.price_filter_fields.hide();
        }

        form.price_filter.on('change', function () {
            form.price_filter_fields.hide();
            if (this.checked) {
                form.price_filter_fields.show();
            }
        });

        if (form.star_filter.checked) {
            form.star_filter_fields.show();
        } else {
            form.star_filter_fields.hide();
        }

        form.star_filter.on('change', function () {
            form.star_filter_fields.hide();
            if (this.checked) {
                form.star_filter_fields.show();
            }
        });

    });

});
