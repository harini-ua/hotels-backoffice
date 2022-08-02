jQuery(document).ready(function ($) {

    $('.cities-list-wrapper').each(function () {
        var $this = $(this);

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

});
