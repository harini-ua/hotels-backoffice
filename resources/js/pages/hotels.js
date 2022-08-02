jQuery(document).ready(function ($) {

    $('.hotels-list-wrapper').each(function () {

        const $this = $(this);

        const forms = {
            filter: {
                country: $this.find('#country_id'),
                city: $this.find('#city_id'),
                submit: $this.find('#hotel-submit-btn'),
            },
        };

        $this.on('change', '.linked', function() {
            $.ajax({
                url: this.dataset.url.replace('[id]', this.value),
                type: "GET",
                success: data => {
                    let selector = '[data-linked="'+this.id+'"]';
                    if (data.length >= 1) {
                        reloadOptions(selector, data);
                        if (data.length === 1) {
                            $(selector).prop("disabled", true);
                        }
                    } else {
                        $(selector).prop("disabled", true);
                    }
                },
                error: data => console.error('Error:', data)
            });
        });

        const reloadOptions = (selector, options) => {
            $(selector).html('');
            $(selector).prop("disabled", false);
            options.forEach(option => {
                if (option.id) {
                    $(selector).append('<option value="'+option.id+'">'+option.name+'</option>')
                } else {
                    $(selector).append('<option class="first_default" selected>'+option.name+'</option>')
                }
            });
            $(selector).select2();
        }

        forms.filter.submit.on('click', (e) => {
            e.preventDefault();

            filters.set(forms.filter.country.attr('name'), forms.filter.country.find(':selected').val());
            filters.set(forms.filter.city.attr('name'), forms.filter.city.find(':selected').val());

            if (forms.filter.country.find(':selected').val() && forms.filter.city.find(':selected').val()) {
                const table = $('#' + forms.filter.submit.attr('data-table')).DataTable();
                let url = forms.filter.submit.attr('data-url');
                table.ajax.url(filters.url(url)).load();
            } else {
                swal('Oops!', 'Select all fields to search.', 'error');
            }
        });

        $('.dataTable').on('click', '.save-row', function(e) {
            let data = {}
            let row = $(this).closest('tr')

            swal({
                title: 'Are you sure?',
                text: 'Hotel data will be updated!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                let validate = true;
                let message = 'Something went wrong, try again.';

                row.find('td.column-edit .edit-field').each(function () {
                    if ($(this).attr('name') === 'commission') {
                        if ($(this).val() && !$.isNumeric($(this).val())) {
                            validate = false
                            message = 'Commission field must be numeric.'
                        }
                        data[$(this).attr('name')] = $(this).val();
                    }

                    if ($(this).attr('name') === 'blacklisted') {
                        data[$(this).attr('name')] = $(this).prop('checked') ? 1 : 0;
                    }
                });

                if (validate) {
                    $.post($(this).data('action'), data);
                } else {
                    swal('Error!', message, 'error');
                }
            })
        });
    });

    $('.hotels-edit-wrapper').each(function () {
        const $this = $(this);
    });

    $('.hotel-images-edit-wrapper').each(function () {
        const $this = $(this);

        const repeater = {
            wrapper: $this.find(".images-repeater"),
            image: $this.find('.image-input'),
            primary: $this.find('.image-type'),
        }

        repeater.image.on('change', function() {
            const [file] = this.files;

            if (file) {
                $(this).closest('.form-group')
                    .find('img.preview')
                    .attr("src", URL.createObjectURL(file))
                    .removeClass('disable');
            }
        });

        repeater.primary.on('change', function() {
            $this.find('.image-type').prop('checked', false);
            $(this).prop('checked', true);
        });

        var imageItemId = 1;
        repeater.wrapper.repeater({
            show: function () {
                imageItemId++;
                $(this).show();

                $(this).find('.preview').attr('src', '');

                $(this).find('input.image-input').on('change', function() {
                    const [file] = this.files;

                    if (file) {
                        $(this).closest('.form-group')
                            .find('img.preview')
                            .attr("src", URL.createObjectURL(file));
                    }
                });
            },
            hide: function (item) {
                swal({
                    title: 'Are you sure?',
                    text: 'Are you sure you want to delete this image',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.value) {
                        $(this).hide(item);
                    }
                });
            }
        });
    });

});
