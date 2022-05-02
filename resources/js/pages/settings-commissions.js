jQuery(document).ready(function ($) {

    $('.settings-commissions-edit-wrapper').each(function () {
        var $this = $(this);

        let commissions = {
            cities: $this.find(".cities-commissions-repeater"),
            countries: $this.find(".countries-commissions-repeater"),
        }

        var citiesUniqueId = 1;
        $this.find(".cities-commissions-repeater").repeater({
            show: function () {
                citiesUniqueId++;
                $this.find(".cities-commissions-repeater").find(".select2-container--default").remove();
                $this.find(".cities-commissions-repeater").find(".select2-single").select2()
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

        var countriesUniqueId = 1;
        $this.find(".countries-commissions-repeater").repeater({
            show: function () {
                countriesUniqueId++;
                $this.find(".countries-commissions-repeater").find(".select2-container--default").remove();
                $this.find(".countries-commissions-repeater").find(".select2-single").select2()
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
