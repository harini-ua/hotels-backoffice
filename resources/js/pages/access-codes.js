jQuery(document).ready(function ($) {

    $('.companies-edit-wrapper').each(function () {
        var $this = $(this);

        let form = {
            access_code: $this.find('.view-access-codes'),
            codes: $this.find('#codes'),
        }

        form.access_code.on('click', (e) => {
            e.preventDefault();

            $.ajax({
                url      : form.access_code.attr('href'),
                type     : 'GET',
                dataType : 'json',
                success  : function(response) {
                    if (response.success === true) {
                        form.codes.text(response.codes)
                    }
                },
            })
        });
    });

});
