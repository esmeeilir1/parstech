@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vazirmatn@34.0.2/dist/font-face.css" />
<style>
:root {
    --main-cyan: #00d2d2;
    --main-cyan-dark: #00b3b3;
    --main-bg: #fafbfc;
    --main-grey: #f8fafd;
}
body, .invoice-print {
    font-family: Vazirmatn, Tahoma, Arial, sans-serif !important;
    background: var(--main-bg);
}
.invoice-print {
    max-width: 820px;
    margin: 30px auto;
    background: #fff;
    border-radius: 22px;
    padding: 35px 40px 15px 40px;
    box-shadow: 0 4px 32px 0 #00000014;
    position: relative;
    direction: rtl;
    color: #222;
}
.invoice-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 25px;
}
.invoice-header .logo {
    width: 100px;
    height: 100px;
    object-fit: contain;
}
.invoice-header .company-info {
    text-align: right;
    flex: 1;
}
.invoice-header .company-info h1 {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 3px;
    color: var(--main-cyan);
}
.invoice-header .company-info .subtitle {
    font-size: 1.04rem;
    font-weight: normal;
    color: #222;
}
.invoice-header .meta {
    text-align: left;
    min-width: 150px;
    font-size: 1.01rem;
    line-height: 1.8;
}
.invoice-title {
    font-size: 2.4rem;
    font-weight: 900;
    display: inline-block;
    margin: 18px 0 24px 0;
    padding: 0 20px 2px 20px;
    background: linear-gradient(90deg, var(--main-cyan) 0 30%, transparent 60% 100%);
    color: #111;
    border-radius: 12px 0 12px 0;
    letter-spacing: -2px;
    box-shadow: 0 6px 18px 0 #00d2d22a;
}
.invoice-customer {
    font-size: 1.07rem;
    margin-bottom: 18px;
    font-weight: 500;
    color: #333;
}
.invoice-table {
    width: 100%;
    border-radius: 18px;
    overflow: hidden;
    margin-bottom: 18px;
    background: var(--main-grey);
    box-shadow: 0 0 0 1.5px #e2e8f0;
}
.invoice-table th {
    background: var(--main-cyan);
    color: #fff;
    text-align: center;
    font-size: 1.04rem;
    padding: 10px 0;
}
.invoice-table td {
    background: #fff;
    padding: 8px 0;
    text-align: center;
    font-size: 1.02rem;
    font-family: inherit;
    border-bottom: 1px solid #e2e8f0;
}
.invoice-table tr:last-child td {
    border-bottom: none;
}
.invoice-summary {
    margin: 28px 0 10px 0;
    padding: 0 0 12px 0;
    border-bottom: 1.5px solid #eee;
}
.invoice-summary-row {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 30px;
    margin-bottom: 5px;
    font-size: 1.09rem;
}
.invoice-summary-row .label {
    min-width: 100px;
    text-align: left;
    color: #888;
}
.invoice-summary-row .value {
    min-width: 120px;
    text-align: left;
    color: #111;
    font-weight: bold;
}
.invoice-about {
    margin-top: 26px;
    font-size: 1.05rem;
    background: #f2fffd;
    border-right: 7px solid var(--main-cyan);
    padding: 11px 15px;
    border-radius: 0 13px 13px 0;
    color: #333;
}
.invoice-footer {
    margin-top: 36px;
    background: #51f7f70d;
    padding: 25px 18px 18px 18px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 1.02rem;
    color: #222;
    flex-wrap: wrap;
    gap: 12px;
}
.invoice-footer .left {
    display: flex;
    align-items: center;
    gap: 15px;
}
.invoice-footer .dot {
    width: 8px;
    height: 8px;
    background: var(--main-cyan);
    border-radius: 50%;
    display: inline-block;
    margin: 0 7px;
}
.invoice-footer .contact {
    color: var(--main-cyan-dark);
    font-weight: 700;
}

.invoice-icons {
    margin: 32px 0 0 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 32px;
    opacity: 0.8;
}
.invoice-icons svg {
    width: 54px;
    height: 54px;
    fill: #00d2d2;
    background: #e8fcfc;
    border-radius: 48%;
    box-shadow: 0 2px 10px #00d2d225;
    padding: 6px;
}
@media print {
    body, .invoice-print { background: #fff !important; }
    .invoice-print { box-shadow: none !important; }
    .no-print { display: none !important; }
}
</style>
@endpush

@section('content')
<div class="invoice-print" id="invoicePrint">
    <div class="invoice-header">
        <div class="company-info">
            <h1>{{ config('invoice.shop_title', 'مرکز خدمات (کامپیوتر،کافی نت، موبایل)') }}</h1>
            <div class="subtitle">{{ config('invoice.shop_subtitle', 'پارس تک') }}</div>
        </div>
        <img src="{{ asset(config('invoice.logo_path', 'images/logo.png')) }}" class="logo" alt="لوگو شرکت">
        <div class="meta">
            <div>شماره: {{ fa_number($invoice->number) }}</div>
            <div>تاریخ: {{ fa_number(jdate($invoice->date)->format('Y/m/d')) }}</div>
        </div>
    </div>

    <div class="invoice-title">
        فاکتور فروش
    </div>
    <div class="invoice-customer">
        خریدار/شرکت/سازمان:
        <span>{{ $invoice->customer->full_name ?? $invoice->customer->name ?? '-' }}</span>
        @if($invoice->customer && $invoice->customer->address)
            <span style="font-size:0.98rem; color:#888;">
                | {{ $invoice->customer->address }}
            </span>
        @endif
    </div>
    <table class="invoice-table">
        <thead>
        <tr>
            <th>محصول</th>
            <th>قیمت (ریال)</th>
            <th>تعداد</th>
            <th>جمع کل (ریال)</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->product->name ?? $item->product_name }}</td>
                <td>{{ fa_number(number_format($item->price, 2, '.', ',')) }}</td>
                <td>{{ fa_number(number_format($item->qty, 0, '.', ',')) }}</td>
                <td>{{ fa_number(number_format($item->price * $item->qty, 2, '.', ',')) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="invoice-summary">
        <div class="invoice-summary-row">
            <span class="label">جمع کل (ریال)</span>
            <span class="value">{{ fa_number(number_format($invoice->total, 2, '.', ',')) }}</span>
        </div>
        <div class="invoice-summary-row">
            <span class="label">تخفیف (ریال)</span>
            <span class="value">{{ fa_number(number_format($invoice->discount_amount, 2, '.', ',')) }}</span>
        </div>
        <div class="invoice-summary-row">
            <span class="label">مالیات (%)</span>
            <span class="value">{{ fa_number(number_format($invoice->tax_percent, 2, '.', ',')) }}</span>
        </div>
        <div class="invoice-summary-row">
            <span class="label">مبلغ نهایی (ریال)</span>
            <span class="value" style="font-size:1.2rem;color:var(--main-cyan-dark);">
                {{ fa_number(number_format($invoice->final_amount, 2, '.', ',')) }}
            </span>
        </div>
    </div>

    <div class="invoice-about">
        <b>درباره ما</b><br>
        {{ config('invoice.shop_about', 'مرکز خدمات پارس تک ارائه دهنده انواع خدمات کامپیوتر، کافی نت، موبایل به صورت حضوری و غیرحضوری. میتوانید تنها با تماس، پیامک، ارسال پیام در شبکه های اجتماعی و ... کارهای خود را انجام دهید.') }}
    </div>
    <div class="invoice-icons">
        {{-- شما می‌توانید این SVGها را با آیکون‌های دلخواه خود جایگزین کنید --}}
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><circle cx="24" cy="24" r="20" fill="#fff"/><path d="M24 8a16 16 0 100 32 16 16 0 000-32zm0 29a13 13 0 110-26 13 13 0 010 26zm0-20a1 1 0 011 1v7h5a1 1 0 110 2h-6a1 1 0 01-1-1v-8a1 1 0 011-1z"/></svg>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><circle cx="24" cy="24" r="20" fill="#fff"/><path d="M12 34l10-10 10 10M12 14h24"/></svg>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><circle cx="24" cy="24" r="20" fill="#fff"/><path d="M24 14l10 10-10 10-10-10 10-10z"/></svg>
    </div>
    <div class="invoice-footer">
        <span class="contact">{{ config('invoice.website', 'www.tepars.ir') }}</span>
        <span class="dot"></span>
        <span class="contact">{{ config('invoice.email', 'tepars.ir@gmail.com') }}</span>
        <span class="dot"></span>
        <span class="contact">{{ config('invoice.phone', '۰۹۳۸۸۰۷۲۱۹') }}</span>
    </div>
    <button class="no-print btn btn-info mt-4" onclick="window.print()">چاپ فاکتور</button>
    <a href="{{ route('invoices.pdf', $invoice->id) }}" class="no-print btn btn-success mt-4" target="_blank">دریافت PDF</a>
</div>
@endsection

@php
// تبدیل اعداد به فارسی
function fa_number($str) {
    return strtr($str, ['0'=>'۰','1'=>'۱','2'=>'۲','3'=>'۳','4'=>'۴','5'=>'۵','6'=>'۶','7'=>'۷','8'=>'۸','9'=>'۹','.'=>'.',','=>'،']);
}
@endphp
