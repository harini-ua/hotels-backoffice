jQuery(document).ready(function ($) {

    $('.booking-users-create-wrapper').each(function () {
        $('form').on('change', '.linked', function() {
            $.ajax({
                url: this.dataset.url.replace('[id]', this.value),
                type: "GET",
                success: data => {
                    if (data.length) {
                        reloadOptions('[data-linked="'+this.id+'"]', data);
                    }
                },
                error: data => console.error('Error:', data)
            });

            const reloadOptions = (selector, options) => {
                $(selector).html('');
                options.forEach(option => {
                    if (option.id) {
                        $(selector).append('<option value="'+option.id+'">'+option.name+'</option>')
                    } else {
                        $(selector).append('<option class="first_default" selected>'+option.name+'</option>')
                    }
                });
                $(selector).select2();
            }
        });

        $('.same-wrapper').each(function () {
            let $this = $(this);
            $('.same').on('click', function () {
                const same = $(this).data('same');
                $this.find('.insert').val(
                    document.getElementById(same).value
                );
            });
        });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.booking-users-show-wrapper').each(function () {
        var $this = $(this);

        var password = {
            form: $this.find('#password-user'),
            input: $this.find('input#password'),
            btn: {
                change: $this.find('.change-pass'),
                send: $this.find('.send-pass'),
            },
            action: {
                change: $this.find('.change-pass').data('action'),
                send: $this.find('.send-pass').data('action')
            }
        }

        password.btn.change.on('click', (e) => {
            const formData = new FormData(password.form.get(0));
            if (formData.get('password')) {
                swal({
                    title: 'Are you sure?',
                    text: 'Password will be changed!',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, change!',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url      : password.action.change,
                            type     : 'POST',
                            dataType : 'json',
                            data     : { _method: 'POST' },
                            success  : function(response) {
                                if (response.success === true) {
                                    swal({
                                        title : response.success === false ? 'Error!' : 'Successfully!',
                                        text  : response.message,
                                        type  : response.success === false ? 'error' : 'success',
                                    }).then((value) => {});
                                } else {
                                    swal('Error!', 'Password has not been changed!', 'error');
                                }
                            },
                            error    : function(data) {
                                swal('Error!', 'Password has not been changed!', 'error');
                            }
                        })
                    }
                })
            }
        });

        password.btn.send.on('click', (e) => {
            swal({
                title: 'Are you sure?',
                text: 'Send password to email!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, send!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url      : password.action.send,
                        type     : 'POST',
                        dataType : 'json',
                        data     : { _method: 'POST' },
                        success  : function(response) {
                            if (response.success === true) {
                                swal({
                                    title : response.success === false ? 'Error!' : 'Successfully!',
                                    text  : response.message,
                                    type  : response.success === false ? 'error' : 'success',
                                }).then((value) => {});
                            } else {
                                swal('Error!', 'Password has not been send!', 'error');
                            }
                        },
                        error    : function(data) {
                            swal('Error!', 'Password has not been send!', 'error');
                        }
                    })
                }
            })
        });
    });

});
