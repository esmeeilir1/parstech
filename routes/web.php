<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PreInvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuickSaleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UnitController;

// Landing page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Persons
    Route::prefix('persons')->name('persons.')->group(function () {
        Route::get('/', [PersonController::class, 'index'])->name('index');
        Route::get('/create', [PersonController::class, 'create'])->name('create');
        Route::post('/store', [PersonController::class, 'store'])->name('store');
        Route::get('/customers', [PersonController::class, 'customers'])->name('customers');
        Route::get('/suppliers', [PersonController::class, 'suppliers'])->name('suppliers');

    });

    // Sales
    Route::prefix('sales')->name('sales.')->group(function () {
        Route::get('/', [SalesController::class, 'index'])->name('index');
        Route::get('/create', [SalesController::class, 'create'])->name('create');
        Route::post('/', [SalesController::class, 'store'])->name('store');
        Route::get('/returns', [SalesController::class, 'returns'])->name('returns');
        Route::post('/returns', [SalesController::class, 'storeReturn'])->name('returns.store');
    });

    // Accounting
    Route::prefix('accounting')->name('accounting.')->group(function () {
        Route::get('/journal', [AccountingController::class, 'journal'])->name('journal');
        Route::get('/ledger', [AccountingController::class, 'ledger'])->name('ledger');
        Route::get('/balance', [AccountingController::class, 'balance'])->name('balance');
    });

    // Financial
    Route::prefix('financial')->name('financial.')->group(function () {
        Route::get('/income', [FinancialController::class, 'income'])->name('income');
        Route::get('/expenses', [FinancialController::class, 'expenses'])->name('expenses');
        Route::get('/banking', [FinancialController::class, 'banking'])->name('banking');
        Route::get('/cheques', [FinancialController::class, 'cheques'])->name('cheques');
    });

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('/inventory', [ReportController::class, 'inventory'])->name('inventory');
        Route::get('/financial', [ReportController::class, 'financial'])->name('financial');
    });

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/company', [SettingsController::class, 'company'])->name('company');
        Route::get('/users', [SettingsController::class, 'users'])->name('users');
    });

    // Products and Categories
    Route::resource('products', ProductController::class);
    Route::post('/products/upload', [ProductController::class, 'upload'])->name('products.upload');
    Route::resource('categories', CategoryController::class)->except(['show']);

    Route::resource('services', ServiceController::class);

    // Stock Management
    Route::prefix('stocks')->name('stocks.')->group(function () {
        Route::get('/in', [StockController::class, 'in'])->name('in');
        Route::get('/out', [StockController::class, 'out'])->name('out');
        Route::get('/transfer', [StockController::class, 'transfer'])->name('transfer');
    });

    // Invoices
    Route::get('/invoices/next-number', [InvoiceController::class, 'getNextNumber'])->name('invoices.next-number');

    Route::resource('invoices', InvoiceController::class);
    Route::resource('pre-invoices', PreInvoiceController::class);
    Route::get('/quick-sale', [QuickSaleController::class, 'index'])->name('quick-sale');
    Route::get('/api/invoices/next-number', [InvoiceController::class, 'getNextNumber']);

    // Other Resources
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/units', [UnitController::class, 'store'])->name('units.store');
});
Route::middleware('auth')->group(function () {
    // قبل از require __DIR__.'/auth.php
    // در کنار سایر route های persons این route را اضافه کنید
    Route::get('/api/persons/next-code', [PersonController::class, 'getNextCode'])->name('persons.next-code');
});
Route::get('/categories/person-search', [\App\Http\Controllers\CategoryController::class, 'personSearch'])->name('categories.person-search');

Route::get('/provinces/{province}/cities', [ProvinceController::class, 'cities'])->name('provinces.cities');
Route::get('/provinces/{province}/cities', [\App\Http\Controllers\ProvinceController::class, 'cities'])->name('provinces.cities');
Route::resource('persons', \App\Http\Controllers\PersonController::class);
Route::get('/invoices/next-number', [InvoiceController::class, 'getNextNumber'])->name('invoices.next-number');

Route::get('/api/persons/search', [App\Http\Controllers\PersonController::class, 'searchAjax'])->name('persons.search.ajax');
Route::resource('currencies', CurrencyController::class)->except(['create', 'edit', 'show']);

Route::get('/currencies', [App\Http\Controllers\CurrencyController::class, 'index'])->name('currencies.index');

// افزودن ارز جدید
Route::post('/currencies', [\App\Http\Controllers\CurrencyController::class, 'store']);

// ویرایش ارز
Route::post('/currencies/{currency}', [\App\Http\Controllers\CurrencyController::class, 'update']);

// حذف ارز
Route::delete('/currencies/{currency}', [\App\Http\Controllers\CurrencyController::class, 'destroy']);

Route::get('shareholders', [\App\Http\Controllers\ShareholderController::class, 'index'])->name('shareholders.index');


Route::middleware(['auth'])->group(function () {
    Route::prefix('sellers')->name('sellers.')->group(function () {
        Route::get('/create', [App\Http\Controllers\SellerController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\SellerController::class, 'store'])->name('store');
        Route::get('/next-code', [App\Http\Controllers\SellerController::class, 'nextCode'])->name('next-code');
        Route::get('/', [App\Http\Controllers\SellerController::class, 'index'])->name('index');
        Route::get('/{seller}', [App\Http\Controllers\SellerController::class, 'show'])->name('show');
        Route::get('/{seller}/edit', [App\Http\Controllers\SellerController::class, 'edit'])->name('edit');
        Route::put('/{seller}', [App\Http\Controllers\SellerController::class, 'update'])->name('update');
        Route::delete('/{seller}', [App\Http\Controllers\SellerController::class, 'destroy'])->name('destroy');
    });
});
Route::get('/api/sellers/list', [App\Http\Controllers\SellerController::class, 'list'])->name('sellers.list');
Route::get('/api/products/search', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
Route::get('/invoices/{id}/pdf', [\App\Http\Controllers\InvoiceController::class, 'pdf'])->name('invoices.pdf');
require __DIR__.'/auth.php';
