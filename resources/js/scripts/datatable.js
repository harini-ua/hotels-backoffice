
$(document).ready(function () {

    $('.dataTable').on('click', '.delete-link', function(e) {
        e.preventDefault();

        var $this = $(this);

        swal({
            title: 'Are you sure?',
            text: 'Resource will be deleted!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url      : $(this).data('remove'),
                    type     : 'DELETE',
                    dataType : 'json',
                    data     : { _method: 'DELETE' },
                    success  : function(response) {
                        if (response.success === true) {
                            var dataTable = $('.dataTable').DataTable();
                            var row = $this.parents('tr');

                            if ($(row).hasClass('child')) {
                                dataTable.row($(row).prev('tr')).remove().draw();
                            } else {
                                dataTable.row($(this).parents('tr')).remove().draw();
                            }
                        }
                        swal({
                            title : response.success === false ? 'Error!' : 'Successfully!',
                            text  : response.message,
                            type  : response.success === false ? 'error' : 'success',
                        }).then((value) => {});
                    },
                    error    : function(data) {
                        swal('Error!', 'Resource has not been deleted!', 'error');
                    }
                }).always(function (data) {
                    $('#clients-list-datatable').DataTable().draw(false);
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                return false;
            }
        })
    });

})
