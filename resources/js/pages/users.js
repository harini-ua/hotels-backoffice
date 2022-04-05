jQuery(document).ready(function ($) {

    $('.users-create-wrapper').each(function () {
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

});
