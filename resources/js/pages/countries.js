jQuery(document).ready(function ($) {

    $('.countries-list-wrapper').each(function () {
        var $this = $(this);

        $('.dataTable').on('change', '.active-switch', function(e) {
            $.post($(this).data('action'));
        });
    });

    $('.countries-edit-wrapper').each(function () {
        var $this = $(this);

        const form = {
            locations: {
                form: $this.find('#country-update-locations'),
                google_api_key: $this.find('#google_api_key'),
                btn: {
                    run: $this.find('.run'),
                }
            }
        }

        form.locations.btn.run.on('click', (e) => {
            e.preventDefault();

            var $this = $(this);

            if (form.locations.google_api_key.val()) {
                $.ajax({
                    url      : form.locations.form.attr('action'),
                    type     : 'POST',
                    dataType : 'json',
                    data     : {
                        _method: 'POST',
                        google_api_key: form.locations.google_api_key.val()
                    },
                    success  : function(response) {
                        if (response.total) {
                            $this.find('.update-results')
                                .append('<div class="alert alert-'+ response.total.status +' alert-dismissible fade show" role="alert">\n' +
                                    response.total.message +
                                    '        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                                    '            <span aria-hidden="true">×</span>\n' +
                                    '        </button>\n' +
                                    '    </div>').show()
                        }

                        if (response.debug) {
                            for(var item in response.debug) {
                                console.log(item, response.debug[item]);
                                $this.find('.update-results')
                                    .append('<div class="alert alert-danger" alert-dismissible fade show" role="alert">\n' +
                                        '        <strong>' + response.debug[item].name + '</strong> - ' + response.debug[item].message +
                                        '        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                                        '            <span aria-hidden="true">×</span>\n' +
                                        '        </button>\n' +
                                        '    </div>').show()
                            }
                        }
                    },
                })
            } else {
                swal('Error!', 'Google API key is required', 'error');
            }
        });
    });

});
