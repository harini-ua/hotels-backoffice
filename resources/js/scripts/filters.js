
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

            if ($(this).hasClass('linked')) {
                $.ajax({
                    url: this.dataset.action.replace('[id]', this.value),
                    type: "GET",
                    success: data => {
                        if (data.length) {
                            reloadOptions('[data-linked="'+this.id+'"]', data);
                        }
                    },
                    error: data => console.error('Error:', data)
                });

                const reloadOptions = (selector, options) => {
                    $(selector).html('');
                    $(selector).prop("disabled", false);
                    options.forEach(option => {
                        if (option.id) {
                            $(selector).append('<option value="'+option.id+'">'+option.name+'</option>')
                        } else {
                            $(selector).append('<option class="first_default" value="" selected>'+option.name+'</option>')
                        }
                    });
                    $(selector).select2();
                }
            }

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

    // Date filter
    const dateFilter = $(".date-filter");
    const route = dateFilter.attr('data-url') ? dateFilter.attr('data-url') : location.href;
    const table = $('#' + dateFilter.attr('data-table')).DataTable();
    dateFilter.find("input").on('change', function(e) {
        alert(1);
        e.preventDefault();
        const name = this.getAttribute('name');
        filters.set(name, this.value);
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
