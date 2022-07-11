jQuery(document).ready(function ($) {

    $('.company-translations-edit-wrapper').each(function () {
        const $this = $(this);

        const forms = {
            company: $this.find('#company_id'),
            btn: {
                submit: $this.find('#get_translations'),
            }
        };

        $('textarea.summernote-editor').summernote({
            height: 150,
            minHeight: null,
            maxHeight: null,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link']],
            ]
        });

        forms.btn.submit.on('click', (e) => {
            e.preventDefault();

            if (forms.company.val()) {
                let params = {}
                params.company = forms.company.find(':selected').val()

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
