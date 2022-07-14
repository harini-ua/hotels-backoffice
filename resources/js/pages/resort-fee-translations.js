jQuery(document).ready(function ($) {

    $('.resort-fee-translations-edit-wrapper').each(function () {
        const $this = $(this);

        const forms = {
            language: $this.find('#language_id'),
            btn: {
                submit: $this.find('#get_translations'),
            }
        };

        forms.btn.submit.on('click', (e) => {
            e.preventDefault();

            if (forms.language.val()) {
                let params = {}
                params.language = forms.language.find(':selected').val()

                $.pjax({
                    url: makeUrl({
                        params: params
                    }),
                    container: '[data-pjax]'
                });
            } else {
                swal('Oops!', 'Please select company field!', 'error');
            }
        });

        $(document).on('pjax:complete', function() {
            initEditor()
        });

        function makeUrl(options) {
            const url = new URL(options.route ? options.route : window.location.href);
            for (let name in options.params) {
                url.searchParams.set(name, options.params[name]);
            }
            return url.href;
        }
    });

    $('.resort-fee-translations-create-wrapper').each(function () {
        const $this = $(this);

        $('form').on('change', '.linked', function() {
            $.ajax({
                url: this.dataset.url.replace('[id]', this.value),
                type: "GET",
                success: data => {
                    let selector = '[data-linked="'+this.id+'"]';
                    if (data.length >= 1) {
                        reloadOptions(selector, data);
                        if (data.length === 1) {
                            $(selector).prop("disabled", true);
                        }
                    } else {
                        $(selector).prop("disabled", true);
                    }
                },
                error: data => console.error('Error:', data)
            });
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
