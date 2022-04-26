jQuery(document).ready(function ($) {

    $('.companies-edit-wrapper').each(function () {
        var $this = $(this);

        const otherForm = {
            chat_enabled: $this.find('#company-others #chat_enabled'),
            default_chat: $this.find('#company-others #default_chat'),
            chat_script: $this.find('#company-others #chat_script'),
            adobe_enabled: $this.find('#company-others #adobe_enabled'),
            default_adobe: $this.find('#company-others #default_adobe'),
            adobe_script: $this.find('#company-others #adobe_script'),
        }

        otherForm.default_chat.hide();
        otherForm.chat_script.closest('.form-group').hide();
        if (otherForm.chat_enabled.val()) {
            otherForm.default_chat.show();
            otherForm.chat_script.closest('.form-group').show();
        }

        otherForm.default_chat.on('click', function () {
            otherForm.chat_script.val($(this).data('default'));
        });

        otherForm.default_adobe.hide();
        otherForm.adobe_script.closest('.form-group').hide();
        if (otherForm.adobe_enabled.val()) {
            otherForm.default_adobe.show();
            otherForm.adobe_script.closest('.form-group').show();
        }

        otherForm.default_adobe.on('click', function () {
            otherForm.adobe_script.val($(this).data('default'));
        });

        otherForm.chat_enabled.on('change', function () {
            otherForm.default_chat.hide();
            otherForm.chat_script.closest('.form-group').hide();
            if (this.checked) {
                otherForm.default_chat.show();
                otherForm.chat_script.closest('.form-group').show();
            }
        });

        otherForm.adobe_enabled.on('change', function () {
            otherForm.default_adobe.hide();
            otherForm.adobe_script.closest('.form-group').hide();
            if (this.checked) {
                otherForm.default_adobe.show();
                otherForm.adobe_script.closest('.form-group').show();
            }
        });
    });

});
