document.addEventListener("DOMContentLoaded", function () {
  // گرفتن همه والدهای زیرمنو
  var treeviewParents = document.querySelectorAll('.nav-item.has-treeview > .nav-link');

  treeviewParents.forEach(function (parentLink) {
    parentLink.addEventListener('click', function (e) {
      e.preventDefault();
      var parent = parentLink.closest('.nav-item');
      var submenu = parent.querySelector('.nav-treeview');

      // اگر زیرمنو وجود ندارد، خروج
      if (!submenu) return;

      // اگر باز بود، ببند با افکت
      if (parent.classList.contains('menu-open')) {
        submenu.style.maxHeight = submenu.scrollHeight + "px"; // مقدار فعلی
        submenu.offsetHeight; // فورس رفرش
        submenu.style.maxHeight = "0";
        submenu.style.opacity = "0";
        submenu.style.paddingTop = "0";
        submenu.style.paddingBottom = "0";
        parent.classList.remove('menu-open');
        setTimeout(function () {
          submenu.removeAttribute("style");
        }, 500);
      } else {
        // اول همه زیرمنوها رو می‌بندیم
        document.querySelectorAll('.nav-item.has-treeview.menu-open').forEach(function (otherParent) {
          var otherMenu = otherParent.querySelector('.nav-treeview');
          if(otherMenu){
            otherMenu.style.maxHeight = otherMenu.scrollHeight + "px";
            otherMenu.offsetHeight;
            otherMenu.style.maxHeight = "0";
            otherMenu.style.opacity = "0";
            otherMenu.style.paddingTop = "0";
            otherMenu.style.paddingBottom = "0";
            otherParent.classList.remove('menu-open');
            setTimeout(function () {
              otherMenu.removeAttribute("style");
            }, 500);
          }
        });
        // باز کردن نرم زیرمنوی فعلی
        submenu.style.display = "block";
        submenu.style.maxHeight = "0";
        submenu.offsetHeight;
        submenu.style.transition = "none";
        submenu.style.maxHeight = submenu.scrollHeight + "px";
        submenu.style.opacity = "1";
        submenu.style.paddingTop = "4px";
        submenu.style.paddingBottom = "6px";
        submenu.offsetHeight;
        submenu.style.transition = "";
        parent.classList.add('menu-open');
        setTimeout(function () {
          submenu.removeAttribute("style");
        }, 600);
      }
    });
  });

  // نمایش زیرمنوی فعال هنگام لود
  document.querySelectorAll('.nav-item.has-treeview.menu-open .nav-treeview').forEach(function(submenu){
    submenu.style.display = "block";
    submenu.style.maxHeight = submenu.scrollHeight + "px";
    submenu.style.opacity = "1";
    submenu.style.paddingTop = "4px";
    submenu.style.paddingBottom = "6px";
    setTimeout(function () {
      submenu.removeAttribute("style");
    }, 800);
  });
});
