document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebar-toggle');
    const submenuHeaders = document.querySelectorAll('.menu-link.has-submenu');
    let openSubmenu = document.querySelector('.submenu.open');

    // باز و بسته کردن سایدبار
    toggleBtn.addEventListener('click', function () {
        sidebar.classList.toggle('collapsed');
    });

    // آکاردئونی حرفه‌ای زیرمنوها با انیمیشن
    submenuHeaders.forEach(header => {
        header.addEventListener('click', function (e) {
            e.preventDefault();
            const submenu = this.nextElementSibling;

            // اگر همین زیرمنو باز بود، ببند
            if (submenu.classList.contains('open')) {
                submenu.classList.remove('open');
                this.setAttribute('aria-expanded', 'false');
                return;
            }

            // بستن همه زیرمنوها
            document.querySelectorAll('.submenu.open').forEach(openMenu => {
                openMenu.classList.remove('open');
                if (openMenu.previousElementSibling) {
                    openMenu.previousElementSibling.setAttribute('aria-expanded', 'false');
                }
            });

            // باز کردن فعلی
            submenu.classList.add('open');
            this.setAttribute('aria-expanded', 'true');
        });
    });

    // اگر منوی باز به خاطر مسیر فعال وجود دارد، اسکرول کن به آن
    if (openSubmenu) {
        openSubmenu.scrollIntoView({ behavior: "smooth", block: "nearest" });
    }
});
