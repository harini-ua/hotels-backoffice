
$('.handle-submit-form').on('submit', function (e) {
    e.preventDefault()
    const form = this,
        formData = new FormData(form),
        url = form.getAttribute('action')
    $(form).find('.error-span').text('')
    $.ajax({
        url,
        type: "POST",
        processData: false,
        contentType: false,
        data: formData,
        success: _ => {
            const table = $('.dataTable');
            table.DataTable().draw(true);
            clearForm(form)
            const dataCreatedItem = $(form).attr('data-created-item')
            Swal.fire(
                'Success!',
                `New ${dataCreatedItem} has been create successful`,
                'success',
            )
        },
        error: response => {
            const errors = {...response.responseJSON.errors}

            for (let key in errors) {
                let formField = ($(form).find(`[name = ${key}] `));
                formField.parents('.input-field').find('.error-span').text(errors[key].join(' '))
            }
        }
    });

    function clearForm(form) {
        Array.prototype.forEach.call(form.elements, element => {
            element.classList.contains('valid') && element.classList.remove('valid')
            if (element.type === 'select-one') {
                element.value = '';
                $(element).formSelect();
            } else if (element.type === 'checkbox') {
                $(element).prop('checked', false);
                $('[data-checkbox="' + $(element).attr('name') + '"]').addClass('hide');
            } else {
                let label = document.querySelector(`label[for="${element.id}"]`);
                label && label.classList.contains('active') && label.classList.remove('active');
                element.value = '';
            }
        });
    }

})
