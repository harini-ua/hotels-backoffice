jQuery(document).ready(function ($) {

    $('.city-translations-edit-wrapper').each(function () {
        const $this = $(this);

        const forms = {
            country: $this.find('#country_id'),
            language: $this.find('#language_id'),
            btn: {
                submit: $this.find('#get_translations'),
            }
        };

        forms.btn.submit.on('click', (e) => {
            e.preventDefault();

            if (forms.country.val() && forms.language.val()) {
                let params = {}
                params.country = forms.country.find(':selected').val()
                params.language = forms.language.find(':selected').val()

                $.pjax({
                    url: makeUrl({
                        params: params
                    }),
                    container: '[data-pjax]'
                });
            } else {
                swal('Oops!', 'Select all field to search!', 'error');
            }
        });

        $(document).on('pjax:complete', function() {
            //..
        });

        function makeUrl(options) {
            const url = new URL(options.route ? options.route : window.location.href);
            for (let name in options.params) {
                url.searchParams.set(name, options.params[name]);
            }
            return url.href;
        }
    });

});
