jQuery(document).ready(function ($) {

    $('.companies-edit-wrapper').each(function () {
        var $this = $(this);

        $('input.image-input').on('change', function() {
            const [file] = this.files;

            if (file) {
                $(this).closest('.form-group')
                    .find('img.preview')
                    .attr("src", URL.createObjectURL(file));
            }
        });

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

        var carouselItemId = 1;
        $this.find(".carousels-repeater").repeater({
            show: function () {
                carouselItemId++;
                $(this).show();

                $(this).find('.carousels-type').val(0);

                $(this).find("textarea.summernote-editor").show().text('')
                $(this).find(".note-editor").remove();
                $(this).find("textarea.summernote-editor").summernote({
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

                $(this).find('.preview').attr('src', '');
                $(this).find('input.image-input').on('change', function() {
                    const [file] = this.files;

                    if (file) {
                        $(this).closest('.form-group')
                            .find('img.preview')
                            .attr("src", URL.createObjectURL(file));
                    }
                });
            },
            hide: function (item) {
                swal({
                    title: 'Are you sure?',
                    text: 'Are you sure you want to delete this item',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.value) {
                        $(this).hide(item);
                    }
                });
            }
        });

        let teaserItemId = 1;
        $this.find(".teasers-repeater").repeater({
            show: function () {
                teaserItemId++;
                $(this).show();

                $(this).find("textarea.summernote-editor").show().text('')
                $(this).find(".note-editor").remove();
                $(this).find("textarea.summernote-editor").summernote({
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

                $(this).find(".custom-select").val($(".custom-select option:first").val());
            },
            hide: function (item) {
                swal({
                    title: 'Are you sure?',
                    text: 'Are you sure you want to delete this item',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.value) {
                        $(this).hide(item);
                    }
                });
            }
        });

    });

});
