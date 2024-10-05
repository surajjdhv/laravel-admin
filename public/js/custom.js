$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Enable tooltips
[...document.querySelectorAll('[data-coreui-toggle="tooltip"]')].map(el => new coreui.Tooltip(el));