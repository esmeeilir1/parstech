document.addEventListener('DOMContentLoaded', function () {
    let success = window.laravelSession?.success;
    let error = window.laravelSession?.error;
    if (success) {
        Swal.fire({
            title: 'موفق!',
            text: success,
            icon: 'success',
            confirmButtonText: 'باشه'
        });
    }
    if (error) {
        Swal.fire({
            title: 'خطا!',
            text: error,
            icon: 'error',
            confirmButtonText: 'باشه'
        });
    }
});
