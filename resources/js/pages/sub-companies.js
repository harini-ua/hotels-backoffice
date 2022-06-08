jQuery(document).ready(function ($) {

    $('.companies-edit-wrapper').each(function () {
        const $this = $(this);

        let subCompanies = 1;
        $this.find(".sub-companies-repeater").repeater({
            show: function () {
                subCompanies++;
                $(this).show();
            },
            hide: function (item) {
                swal({
                    title: 'Are you sure?',
                    text: 'Are you sure you want to delete this commission',
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
