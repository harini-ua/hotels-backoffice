jQuery(document).ready(function ($) {

    $('.companies-list-wrapper').each(function () {
        var $this = $(this);

        $('.dataTable').on('click', '.duplicate-link', function(e) {
            e.preventDefault();

            var $this = $(this);

            swal({
                title: 'Company Site name',
                input: 'text',
                showCancelButton: true,
                confirmButtonText: 'Create',
                showLoaderOnConfirm: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger m-l-10',
                preConfirm: function (name) {
                    return new Promise(function (resolve, reject) {
                        $.ajax({
                            url      : $this.data('duplicate'),
                            type     : 'POST',
                            dataType : 'json',
                            data     : { company_name: name },
                            success  : function(response) {
                                if (response.success === true) {
                                    var dataTable = $('.dataTable').DataTable();
                                    dataTable.draw();
                                }
                                swal({
                                    title : response.success === false ? 'Error!' : 'Successfully!',
                                    text  : response.success === false ? 'Something went wrong, try again.' : 'Company duplicate has been successfully created.',
                                    type  : response.success === false ? 'error' : 'success',
                                }).then((value) => {});
                            },
                            error    : function(data) {
                                swal('Error!', 'Resource has not been duplicate!', 'error');
                            }
                        }).always(function (data) {
                            $('#companies-list-datatable').DataTable().draw(false);
                        });
                    })
                },
                allowOutsideClick: false
            }).then(function (name) {
                //..
            })
        });
    });

    $('.companies-create-wrapper').each(function () {
        var $this = $(this);

        //..
    });

    $('.companies-edit-wrapper').each(function () {
        var $this = $(this);

        //..
    });

});
