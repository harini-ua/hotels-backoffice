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

        const form = {
            loginType: $this.find('#login_type'),
            accessCodes: $this.find('#access_codes'),
        }

        swichAccessCodes(form.loginType.val(), true)

        form.loginType.on('change', function () {
            swichAccessCodes(this.value);
        });

        function swichAccessCodes(login_type, first = false)
        {
            if (!first) form.accessCodes.val('');
            if (login_type === '0') {
                form.accessCodes.closest('.form-group').find('.col-form-label').html('Number codes *');
                form.accessCodes.closest('.form-group').show();
                form.accessCodes.attr('type', 'number');
            }
            if (login_type === '1') {
                form.accessCodes.closest('.form-group').find('.col-form-label').html('Access code *');
                form.accessCodes.closest('.form-group').show();
                form.accessCodes.attr('type', 'text');
            }
            if (login_type === '2') {
                form.accessCodes.closest('.form-group').find('.col-form-label').html('');
                form.accessCodes.closest('.form-group').hide();
            }
        }
    });

    $('.companies-edit-wrapper').each(function () {
        var $this = $(this);

        const otherForm = {
            chat_enabled: $this.find('#company-others #chat_enabled'),
            default_chat: $this.find('#company-others #default_chat'),
            chat_script: $this.find('#company-others #chat_script'),
            adobe_enabled: $this.find('#company-others #adobe_enabled'),
            default_adobe: $this.find('#company-others #default_adobe'),
            adobe_script: $this.find('#company-others #adobe_script'),
        }

        otherForm.default_chat.hide();
        otherForm.chat_script.closest('.form-group').hide();
        if (otherForm.chat_enabled.val()) {
            otherForm.default_chat.show();
            otherForm.chat_script.closest('.form-group').show();
        }

        otherForm.default_chat.on('click', function () {
            otherForm.chat_script.val($(this).data('default'));
        });

        otherForm.default_adobe.hide();
        otherForm.adobe_script.closest('.form-group').hide();
        if (otherForm.adobe_enabled.val()) {
            otherForm.default_adobe.show();
            otherForm.adobe_script.closest('.form-group').show();
        }

        otherForm.default_adobe.on('click', function () {
            otherForm.adobe_script.val($(this).data('default'));
        });

        otherForm.chat_enabled.on('change', function () {
            otherForm.default_chat.hide();
            otherForm.chat_script.closest('.form-group').hide();
            if (this.checked) {
                otherForm.default_chat.show();
                otherForm.chat_script.closest('.form-group').show();
            }
        });

        otherForm.adobe_enabled.on('change', function () {
            otherForm.default_adobe.hide();
            otherForm.adobe_script.closest('.form-group').hide();
            if (this.checked) {
                otherForm.default_adobe.show();
                otherForm.adobe_script.closest('.form-group').show();
            }
        });
        //..
    });

});
