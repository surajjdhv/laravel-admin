// Include csrf token in all ajax requests made by jquery
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// jquery datatables global options
$.extend(true, $.fn.dataTable.defaults, {
    initComplete: function() {}
});

// Enable Core UI tooltips
[...document.querySelectorAll('[data-coreui-toggle="tooltip"]')].map(el => new coreui.Tooltip(el));

$(document).ready(function() {
    // Set the default theme to Bootstrap 5 globally for all Select2 elements
    $.fn.select2.defaults.set('theme', 'bootstrap-5');
    
    // Initialize Select2 for all elements with the 'select2' class
    $('.select2').select2();
});
