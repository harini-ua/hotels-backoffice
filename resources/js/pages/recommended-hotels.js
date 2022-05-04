jQuery(document).ready(function ($) {

    $('.recommended-hotels-index-wrapper').each(function () {
        var $this = $(this);
    });

    $('.recommended-hotels-create-wrapper, .recommended-hotels-edit-wrapper').each(function () {
        var $this = $(this);

        $('form').on('change', '.linked', function() {
            var $this = $(this);

            if (this.value) {
                $.ajax({
                    url: this.dataset.url.replace('[id]', this.value),
                    type: "GET",
                    success: data => {
                        if (data.length) {
                            reloadOptions('[data-linked="'+this.id+'"]', data);

                            if ($('[data-linked="'+this.id+'"]').data('binded-select')) {
                                var bindedSelectId = $('[data-linked="'+this.id+'"]').data('binded-select');
                                $('#'+bindedSelectId).html('');
                                $('#'+bindedSelectId).prop("disabled", true);
                                $('#'+bindedSelectId).append('<option value="">No Avariable</option>')
                            }
                        }
                    },
                    error: data => console.error('Error:', data)
                });
            } else {
                var firstBinded = $this.data('binded-select');
                $('#'+firstBinded).html('');
                $('#'+firstBinded).prop("disabled", true);
                $('#'+firstBinded).append('<option value="">No Avariable</option>')

                var secondBinded = $('#'+firstBinded).data('binded-select');
                $('#'+secondBinded).html('');
                $('#'+secondBinded).prop("disabled", true);
                $('#'+secondBinded).append('<option value="">No Avariable</option>')
            }

            const reloadOptions = (selector, options) => {
                $(selector).html('');
                $(selector).prop("disabled", false);
                options.forEach(option => {
                    if (option.id) {
                        $(selector).append('<option value="'+option.id+'">'+option.name+'</option>')
                    } else {
                        $(selector).append('<option class="first_default" value="" selected>'+option.name+'</option>')
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
