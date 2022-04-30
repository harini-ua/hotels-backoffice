jQuery(document).ready(function ($) {

    $('.companies-edit-wrapper').each(function () {
        var $this = $(this);

        let commissions = {
            level1repeater: $this.find(".level1-commissions-repeater"),
            level2repeater: $this.find(".level2-commissions-repeater"),
        }

        var level1uniqueId = 1;
        $this.find(".level1-commissions-repeater").repeater({
            show: function () {
                level1uniqueId++;
                $this.find(".level1-commissions-repeater").find(".select2-container--default").remove();
                $this.find(".level1-commissions-repeater").find(".select2-single").select2()
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

        var level2uniqueId = 1;
        $this.find(".level2-commissions-repeater").repeater({
            show: function () {
                level2uniqueId++;
                $this.find(".level2-commissions-repeater").find(".select2-container--default").remove();
                $this.find(".level2-commissions-repeater").find(".select2-single").select2()
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
