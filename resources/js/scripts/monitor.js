
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// https://pusher.com/tutorials/server-health-monitor-laravel/
// subscribe to the live-monitor channel and listen to the finished.check event
window.Echo.channel('live-monitor')
    .listen('.finished.check', (e) => {

        const { id, type, last_run_message, element_class, last_update, host_id } = e.message; // destructure the event data

        $(`#${id} .${type}`)
            .text(last_run_message)
            .removeClass('text-success text-danger text-warning')
            .addClass(element_class);

        $(`#${host_id}`).text(`Last update: ${last_update}`);
    });

Visibility.change(function (e, state) {
    $.post('/admin/page-visibility', { state }); // hidden or visible
});
