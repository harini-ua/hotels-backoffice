"use strict";
$(document).ready(function ($) {

    $('.newsletters-create-wrapper').each(function () {
        var $this = $(this);

        const form = {
            registered: $this.find('#registered_date_from'),
            btn: {
                send: $this.find('#send-btn'),
                download: $this.find('#download-btn')
            }
        };

        form.registered.datepicker({
            language: 'en',
            dateFormat: 'dd/mm/yyyy',
            maxDate: new Date(),
            position: 'top left',
        });

        tinymce.init({
            selector: "textarea.tinymce-editor",
            theme: "modern",
            height: 320,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
            style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                {title: 'Example 1', inline: 'span', classes: 'example1'},
                {title: 'Example 2', inline: 'span', classes: 'example2'},
                {title: 'Table styles'},
                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
            ]
        });
    });

});
