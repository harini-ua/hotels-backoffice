
$(document).ready(function () {

    // Filters
    const filterItems = $(".filter-item");
    filterItems.each(id => {
        const filterItem = $(filterItems[id]);
        const route = filterItem.find('.filter-input').attr('data-url');
        const name = filterItem.find('.filter-input').attr('name');
        const table = $('#' + filterItem.find('.filter-input').attr('data-table')).DataTable();

        filterItem.on('change', '.select-filter, .text-filter', function(e) {
            e.preventDefault();
            filters.set(name, this.value);
            table.ajax.url(filters.url(route)).load();
            $(document).trigger({
                type: 'filterChange',
                filters: filters
            });
        });
    });

    // Checkbox filter
    $('.checkbox-filter input').on('change', function(e) {
        e.preventDefault();
        const checkboxFilter = $(this).closest('.checkbox-filter');
        const route = checkboxFilter.attr('data-url') ? checkboxFilter.attr('data-url') : location.href;
        const table = $('#' + checkboxFilter.attr('data-table')).DataTable();
        const name = this.getAttribute('name');

        filters.set(name, this.checked ? this.value : null);
        table.ajax.url(filters.url(route)).load();
        $(document).trigger({
            type: 'filterChange',
            filters: filters
        });
    });

    $(document).on('filterChange', function(e) {
        //
    });
});
