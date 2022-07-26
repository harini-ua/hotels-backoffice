jQuery(document).ready(function ($) {

    $('.hotels-providers-list-wrapper').each(function () {

        const $this = $(this);

        const forms = {
            filter: {
                country: $this.find('#country_id'),
                city: $this.find('#city_id'),
                provider: $this.find('#provider_id'),
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
            filters.set(forms.filter.provider.attr('name'), forms.filter.provider.find(':selected').val());

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
                text: 'Hotel provider data will be updated!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                let validate = true;
                let message = 'Something went wrong, try again.';

                row.find('td.column-edit .edit-field').each(function () {
                    if ($(this).attr('name') === 'blacklisted') {
                        data[$(this).attr('name')] = $(this).prop('checked')
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

});
