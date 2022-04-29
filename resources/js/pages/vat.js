jQuery(document).ready(function ($) {

    $('.companies-edit-wrapper').each(function () {
        var $this = $(this);

        let vat = {
            repeater: $this.find(".vat-repeater"),
        }

        var uniqueId = 1;
        $this.find(".vat-repeater").repeater({
            show: function () {
                uniqueId++;
                $this.find(".vat-repeater").find(".select2-container--default").remove();
                $this.find(".vat-repeater").find(".select2-single").select2()
                $(this).show();
            },
            hide: function (item) {
                swal({
                    title: 'Are you sure?',
                    text: 'Are you sure you want to delete this VAT',
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
