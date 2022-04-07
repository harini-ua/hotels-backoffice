/**
 * Set cookie value
 *
 * @param cname
 * @param cvalue
 * @param exdays
 */
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

/**
 * Get cookie value
 *
 * @param cname
 * @returns {string}
 */
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

/**
 * Custom Filters
 */
class Filters
{
    constructor() {
        this.filters = {};
    }

    get(name) {
        return this.filters[name];
    }

    set(name, filter) {
        if (filter) {
            this.filters = Object.assign({}, this.filters, {
                [name]: filter,
            })
        } else {
            delete (this.filters[name]);
        }
    }

    url(route) {
        const url = new URL(route);
        for (let name in this.filters) {
            url.searchParams.set(name, this.filters[name]);
        }
        return url.href;
    }
}

window.filters = window.filters || new Filters();

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

})
