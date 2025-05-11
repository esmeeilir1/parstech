
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">سیستم حسابداری و فروش</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('img/user.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name ?? 'کاربر' }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                {{-- داشبورد --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>داشبورد</p>
                    </a>
                </li>


                {{-- فروش --}}
                <li class="nav-item has-treeview {{ request()->is('sales*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('sales*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            فروش
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('quick-sale') }}" class="nav-link {{ request()->routeIs('quick-sale') ? 'active' : '' }}">
                                <i class="fas fa-bolt nav-icon"></i>
                                <p>فروش سریع</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('invoices.create') }}" class="nav-link {{ request()->routeIs('invoices.create') ? 'active' : '' }}">
                                <i class="fas fa-file-invoice nav-icon"></i>
                                <p>فروش جدید</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sales.index') }}" class="nav-link {{ request()->routeIs('sales.index') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>لیست فروش‌ها</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sales.returns') }}" class="nav-link {{ request()->routeIs('sales.returns') ? 'active' : '' }}">
                                <i class="fas fa-undo nav-icon"></i>
                                <p>مرجوعی فروش</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- حسابداری --}}
                <li class="nav-item has-treeview {{ request()->is('accounting*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('accounting*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calculator"></i>
                        <p>
                            حسابداری
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('accounting.journal') }}" class="nav-link {{ request()->routeIs('accounting.journal') ? 'active' : '' }}">
                                <i class="fas fa-book nav-icon"></i>
                                <p>دفتر روزنامه</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounting.ledger') }}" class="nav-link {{ request()->routeIs('accounting.ledger') ? 'active' : '' }}">
                                <i class="fas fa-book-open nav-icon"></i>
                                <p>دفتر کل</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounting.balance') }}" class="nav-link {{ request()->routeIs('accounting.balance') ? 'active' : '' }}">
                                <i class="fas fa-balance-scale nav-icon"></i>
                                <p>تراز آزمایشی</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- امور مالی --}}
                <li class="nav-item has-treeview {{ request()->is('financial*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('financial*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-coins"></i>
                        <p>
                            امور مالی
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('financial.income') }}" class="nav-link {{ request()->routeIs('financial.income') ? 'active' : '' }}">
                                <i class="fas fa-arrow-down nav-icon"></i>
                                <p>درآمدها</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('financial.expenses') }}" class="nav-link {{ request()->routeIs('financial.expenses') ? 'active' : '' }}">
                                <i class="fas fa-arrow-up nav-icon"></i>
                                <p>هزینه‌ها</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('financial.banking') }}" class="nav-link {{ request()->routeIs('financial.banking') ? 'active' : '' }}">
                                <i class="fas fa-university nav-icon"></i>
                                <p>عملیات بانکی</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('financial.cheques') }}" class="nav-link {{ request()->routeIs('financial.cheques') ? 'active' : '' }}">
                                <i class="fas fa-money-check-alt nav-icon"></i>
                                <p>مدیریت چک‌ها</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- فاکتورها --}}
                <li class="nav-item has-treeview {{ request()->is('invoices*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('invoices*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            فاکتورها
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('invoices.create') }}" class="nav-link {{ request()->routeIs('invoices.create') ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>صدور فاکتور</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('invoices.index') }}" class="nav-link {{ request()->routeIs('invoices.index') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>لیست فاکتورها</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pre-invoices.index') }}" class="nav-link {{ request()->routeIs('pre-invoices.index') ? 'active' : '' }}">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>پیش فاکتورها</p>
                            </a>
                        </li>
                    </ul>
                </li>

                                                {{-- مدیریت انبار --}}
                <li class="nav-item has-treeview {{ request()->is('products*') || request()->is('stocks*') || request()->is('categories*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('products*') || request()->is('stocks*') || request()->is('categories*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-warehouse"></i>
                        <p>
                            مدیریت انبار
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- افزودن محصول --}}
                        <li class="nav-item">
                            <a href="{{ route('products.create') }}" class="nav-link {{ request()->routeIs('products.create') ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon text-success"></i>
                                <p>افزودن محصول</p>
                            </a>
                        </li>
                        {{-- افزودن خدمت --}}
                        <li class="nav-item">
                            <a href="{{ route('services.create') }}" class="nav-link {{ request()->routeIs('services.create') ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon text-info"></i>
                                <p>افزودن خدمات</p>
                            </a>
                        </li>
                        {{-- لیست محصولات --}}
                        <li class="nav-item">
                            <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
                                <i class="fas fa-box nav-icon"></i>
                                <p>لیست محصولات</p>
                            </a>
                        </li>
                        {{-- ورود کالا --}}
                        <li class="nav-item">
                            <a href="{{ route('stocks.in') }}" class="nav-link {{ request()->routeIs('stocks.in') ? 'active' : '' }}">
                                <i class="fas fa-arrow-down nav-icon"></i>
                                <p>ورود کالا</p>
                            </a>
                        </li>
                        {{-- خروج کالا --}}
                        <li class="nav-item">
                            <a href="{{ route('stocks.out') }}" class="nav-link {{ request()->routeIs('stocks.out') ? 'active' : '' }}">
                                <i class="fas fa-arrow-up nav-icon"></i>
                                <p>خروج کالا</p>
                            </a>
                        </li>
                        {{-- انتقال بین انبارها --}}
                        <li class="nav-item">
                            <a href="{{ route('stocks.transfer') }}" class="nav-link {{ request()->routeIs('stocks.transfer') ? 'active' : '' }}">
                                <i class="fas fa-exchange-alt nav-icon"></i>
                                <p>انتقال بین انبارها</p>
                            </a>
                        </li>
                        {{-- دسته‌بندی --}}
                        <li class="nav-item">
                            <a href="{{ route('categories.create') }}" class="nav-link {{ request()->routeIs('categories.create') ? 'active' : '' }}">
                                <i class="fas fa-tags nav-icon"></i>
                                <p>دسته‌بندی</p>
                            </a>
                        </li>
                        {{-- لیست دسته‌بندی --}}
                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}">
                                <i class="fas fa-list-ul nav-icon"></i>
                                <p>لیست دسته‌بندی</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- اشخاص --}}
                <li class="nav-item has-treeview {{ request()->is('persons*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('persons*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            اشخاص
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('persons.create') }}" class="nav-link {{ request()->routeIs('persons.create') ? 'active' : '' }}">
                                <i class="fas fa-user-friends nav-icon"></i>
                                <p>شخص جدید</p>
                            </a>
                        </li>
                        {{-- لیست اشخاص --}}
                        <li class="nav-item">
                            <a href="{{ route('persons.index') }}" class="nav-link {{ request()->routeIs('persons.index') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>لیست اشخاص</p>
                            </a>
                        </li>
                            {{-- منوی سهامداران --}}
                        <li class="nav-item">
                            <a href="{{ route('shareholders.index') }}" class="nav-link {{ request()->routeIs('shareholders.*') ? 'active' : '' }}">
                                <i class="fas fa-user-shield nav-icon"></i>
                                <p>سهامداران</p>
                            </a>
                        </li>
                        {{-- منوی مشتریان --}}
                        <li class="nav-item">
                            <a href="{{ route('sellers.create') }}" class="nav-link {{ request()->routeIs('sellers.create') ? 'active' : '' }}">
                                <i class="fas fa-store nav-icon"></i>
                                <p>فروشنده جدید</p>
                            </a>
                        </li>
                        {{-- لیست فروشنده --}}
                        <li class="nav-item">
                            <a href="{{ route('sellers.index') }}" class="nav-link {{ request()->routeIs('sellers.index') ? 'active' : '' }}">
                                <i class="fas fa-user-tie nav-icon"></i>
                                <p>لیست فروشندگان</p>
                            </a>
                        </li>
                        {{-- صفحه فروشنده --}}

                        <li class="nav-item">
                            <a href="{{ route('persons.suppliers') }}" class="nav-link {{ request()->routeIs('persons.suppliers') ? 'active' : '' }}">
                                <i class="fas fa-truck nav-icon"></i>
                                <p>تامین‌کنندگان</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- گزارشات --}}
                <li class="nav-item has-treeview {{ request()->is('reports*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('reports*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            گزارشات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('reports.sales') }}" class="nav-link {{ request()->routeIs('reports.sales') ? 'active' : '' }}">
                                <i class="fas fa-chart-line nav-icon"></i>
                                <p>گزارش فروش</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.inventory') }}" class="nav-link {{ request()->routeIs('reports.inventory') ? 'active' : '' }}">
                                <i class="fas fa-boxes nav-icon"></i>
                                <p>گزارش موجودی</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.financial') }}" class="nav-link {{ request()->routeIs('reports.financial') ? 'active' : '' }}">
                                <i class="fas fa-money-bill-wave nav-icon"></i>
                                <p>گزارش مالی</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- تنظیمات --}}
                <li class="nav-item has-treeview {{ request()->is('settings*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('settings*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            تنظیمات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('settings.company') }}" class="nav-link {{ request()->routeIs('settings.company') ? 'active' : '' }}">
                                <i class="fas fa-building nav-icon"></i>
                                <p>اطلاعات شرکت</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('settings.users') }}" class="nav-link {{ request()->routeIs('settings.users') ? 'active' : '' }}">
                                <i class="fas fa-users-cog nav-icon"></i>
                                <p>مدیریت کاربران</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" id="openCurrencyModal">
                                <i class="fas fa-money-bill-wave nav-icon"></i>
                                <p>مدیریت واحدهای پول</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- خروج --}}
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <a href="#" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>خروج</p>
                        </a>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
