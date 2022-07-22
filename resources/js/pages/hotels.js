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
    });

    $('.hotels-edit-wrapper').each(function () {
        const $this = $(this);

        const forms = {
            thumbnail_image: $this.find('#thumbnail_image'),
        };

        forms.thumbnail_image.on('change', function() {
            const [file] = this.files;

            if (file) {
                $(this).closest('.form-group')
                    .find('img.preview')
                    .attr("src", URL.createObjectURL(file))
                    .removeClass('disable');
            }
        });
    });


    $('.hotel-images-edit-wrapper').each(function () {
        const $this = $(this);

        var imageItemId = 1;
        $this.find(".images-repeater").repeater({
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
