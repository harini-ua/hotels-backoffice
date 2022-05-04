jQuery(document).ready(function ($) {

    $('.recommended-hotels-create-wrapper').each(function () {
        var $this = $(this);

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
                $(selector).prop("disabled", false);
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
    });

    $('.recommended-hotels-edit-wrapper').each(function () {
        var $this = $(this);
    });

});
