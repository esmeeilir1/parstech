document.addEventListener('DOMContentLoaded', function () {
    // برای فعال‌سازی tooltipهای بوت‌استرپ (اگر استفاده می‌کنی)
    if (window.bootstrap) {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
            new bootstrap.Tooltip(el);
        });
    }
});
