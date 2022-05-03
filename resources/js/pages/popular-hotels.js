jQuery(document).ready(function ($) {

    $('.popular-hotels-create-wrapper').each(function () {
        var $this = $(this);

        $('#rating').barrating({
            theme: 'fontawesome-stars',
            showSelectedRating: false
        });
    });

    $('.popular-hotels-edit-wrapper').each(function () {
        var $this = $(this);

        $('#rating').barrating({
            theme: 'fontawesome-stars',
            showSelectedRating: false
        });
    });

});
