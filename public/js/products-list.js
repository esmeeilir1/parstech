$(document).ready(function() {
    $('#productsTable').DataTable({
        language: {
            url: '/js/datatables/fa.json'
        }
    });
    $('#servicesTable').DataTable({
        language: {
            url: '/js/datatables/fa.json'
        }
    });

    // Bootstrap تب‌ها (سازگار با Bootstrap 4 و 5)
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });
});
