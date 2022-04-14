jQuery(document).ready(function ($) {

    $('.admins-list-wrapper').each(function () {
        $('.dataTable').on('click', '.qr-action', function(e) {
            e.preventDefault();

            var $this = $(this);

            $.ajax({
                url      : $(this).data('qr'),
                type     : 'GET',
                dataType : 'json',
                data     : { _method: 'GET' },
                success  : function(response) {
                    if (response.success === true) {
                        swal({
                            title: 'BarCode',
                            html: response.qr,
                            confirmButtonText: "Close",
                        });
                    } else {
                        swal('Error!', 'Something went wrong, try again.', 'error');
                    }
                },
                error    : function(data) {
                    swal('Error!', 'Something went wrong, try again.', 'error');
                }
            }).always(function (data) {
                $('#clients-list-datatable').DataTable().draw(false);
            });

        });
    });

});
