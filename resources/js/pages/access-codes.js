jQuery(document).ready(function ($) {

    $('.companies-edit-wrapper').each(function () {
        var $this = $(this);

        let form = {
            access_code: $this.find('#access_code'),
            codes: $this.find('#codes'),
            access_code_last_update: $this.find('#access_code_last_update'),
            action: {
                update_access_code: $this.find('.update_access_code').data('action'),
            },
            btn: {
                update_access_code: $this.find('.update_access_code'),
                view_access_code: $this.find('.view-access-codes'),
            }
        }

        form.btn.view_access_code.on('click', (e) => {
            e.preventDefault();

            $.ajax({
                url      : form.btn.view_access_code.attr('href'),
                type     : 'GET',
                dataType : 'json',
                success  : function(response) {
                    if (response.success === true) {
                        form.codes.html(response.codes)
                    }
                },
            })
        });

        form.btn.update_access_code.on('click', (e) => {
            if (form.access_code.val()) {
                swal({
                    title: 'Are you sure?',
                    text: 'Access code will be updated!',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, updated!',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url      : form.action.update_access_code,
                            type     : 'POST',
                            dataType : 'json',
                            data     : {
                                _method: 'POST',
                                access_code: form.access_code.val()
                            },
                            success  : function(response) {
                                if (response.success === true) {
                                    form.access_code_last_update.val(response.created_at)
                                    swal({
                                        title : response.success === false ? 'Error!' : 'Successfully!',
                                        text  : response.message,
                                        type  : response.success === false ? 'error' : 'success',
                                    }).then((value) => {});
                                } else {
                                    swal('Error!', 'Access code has not been updated!', 'error');
                                }
                            },
                            error    : function(data) {
                                swal('Error!', 'Access code has not been updated!', 'error');
                            }
                        })
                    }
                })
            } else {

            }
        });
    });

});
