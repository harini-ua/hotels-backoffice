jQuery(document).ready(function ($) {

    $('.special-offer-hotels-create-wrapper').each(function () {
        var $this = $(this);

        $('#rating').barrating({
            theme: 'fontawesome-stars',
            showSelectedRating: false
        });
    });

    $('.special-offer-hotels-edit-wrapper').each(function () {
        var $this = $(this);

        $('#rating').barrating({
            theme: 'fontawesome-stars',
            showSelectedRating: false
        });
    });

});
