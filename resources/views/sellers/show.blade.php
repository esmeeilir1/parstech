@extends('layouts.app')

@section('title', 'اطلاعات فروشنده')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sellers/sellers.css') }}">
@endpush
@section('content')
<div class="container py-4">
    <div class="accordion" id="sellerInfoTree">
        <!-- اطلاعات اصلی -->
        <div class="accordion-item tree-node">
            <h2 class="accordion-header" id="mainInfoHeading">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#mainInfo" aria-expanded="true" aria-controls="mainInfo">
                    <i class="bi bi-person"></i> اطلاعات اصلی
                </button>
            </h2>
            <div id="mainInfo" class="accordion-collapse collapse show" aria-labelledby="mainInfoHeading" data-bs-parent="#sellerInfoTree">
                <div class="accordion-body">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <img src="{{ $seller->image ? asset('storage/' . $seller->image) : asset('img/user-default.png') }}" class="rounded-circle mb-2" style="width:96px;height:96px;">
                        </div>
                        <div class="col-md-10">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>کد فروشنده:</strong> {{ $seller->seller_code }}</li>
                                <li class="list-group-item"><strong>نام:</strong> {{ $seller->first_name }}</li>
                                <li class="list-group-item"><strong>نام خانوادگی:</strong> {{ $seller->last_name }}</li>
                                <li class="list-group-item"><strong>نام مستعار:</strong> {{ $seller->nickname }}</li>
                                <li class="list-group-item"><strong>شرکت:</strong> {{ $seller->company_name }}</li>
                                <li class="list-group-item"><strong>عنوان:</strong> {{ $seller->title }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- اطلاعات عمومی -->
        <div class="accordion-item tree-node">
            <h2 class="accordion-header" id="generalInfoHeading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#generalInfo" aria-expanded="false" aria-controls="generalInfo">
                    <i class="bi bi-info-circle"></i> اطلاعات عمومی
                </button>
            </h2>
            <div id="generalInfo" class="accordion-collapse collapse" aria-labelledby="generalInfoHeading" data-bs-parent="#sellerInfoTree">
                <div class="accordion-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>اعتبار مالی:</strong> {{ number_format($seller->credit_limit) }} ریال</li>
                        <li class="list-group-item"><strong>لیست قیمت:</strong> {{ $seller->price_list }}</li>
                        <li class="list-group-item"><strong>نوع مالیات:</strong> {{ $seller->tax_type }}</li>
                        <li class="list-group-item"><strong>کد ملی:</strong> {{ $seller->national_code }}</li>
                        <li class="list-group-item"><strong>کد اقتصادی:</strong> {{ $seller->economic_code }}</li>
                        <li class="list-group-item"><strong>شماره ثبت:</strong> {{ $seller->registration_number }}</li>
                        <li class="list-group-item"><strong>کد شعبه:</strong> {{ $seller->branch_code }}</li>
                        <li class="list-group-item"><strong>توضیحات:</strong> {{ $seller->description }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- اطلاعات تماس -->
        <div class="accordion-item tree-node">
            <h2 class="accordion-header" id="contactInfoHeading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#contactInfo" aria-expanded="false" aria-controls="contactInfo">
                    <i class="bi bi-telephone"></i> اطلاعات تماس
                </button>
            </h2>
            <div id="contactInfo" class="accordion-collapse collapse" aria-labelledby="contactInfoHeading" data-bs-parent="#sellerInfoTree">
                <div class="accordion-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>موبایل:</strong> {{ $seller->mobile }}</li>
                        <li class="list-group-item"><strong>تلفن:</strong> {{ $seller->phone }}</li>
                        <li class="list-group-item"><strong>ایمیل:</strong> {{ $seller->email }}</li>
                        <li class="list-group-item"><strong>وبسایت:</strong> {{ $seller->website }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- اطلاعات آدرس -->
        <div class="accordion-item tree-node">
            <h2 class="accordion-header" id="addressInfoHeading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#addressInfo" aria-expanded="false" aria-controls="addressInfo">
                    <i class="bi bi-geo-alt"></i> آدرس
                </button>
            </h2>
            <div id="addressInfo" class="accordion-collapse collapse" aria-labelledby="addressInfoHeading" data-bs-parent="#sellerInfoTree">
                <div class="accordion-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>کشور:</strong> {{ $seller->country }}</li>
                        <li class="list-group-item"><strong>استان:</strong> {{ $seller->province }}</li>
                        <li class="list-group-item"><strong>شهر:</strong> {{ $seller->city }}</li>
                        <li class="list-group-item"><strong>کدپستی:</strong> {{ $seller->postal_code }}</li>
                        <li class="list-group-item"><strong>آدرس:</strong> {{ $seller->address }}</li>
                    </ul>
                </div>
            </div>
        </div>
            <!-- اطلاعات بانکی -->
        <div class="accordion-item tree-node">
            <h2 class="accordion-header" id="bankInfoHeading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#bankInfo" aria-expanded="false" aria-controls="bankInfo">
                    <i class="bi bi-credit-card-2-back"></i> حساب‌های بانکی
                </button>
            </h2>
            <div id="bankInfo" class="accordion-collapse collapse" aria-labelledby="bankInfoHeading" data-bs-parent="#sellerInfoTree">
                <div class="accordion-body">
                    @if($seller->bankAccounts->count())
                    <ul class="list-group">
                        @foreach($seller->bankAccounts as $b)
                        <li class="list-group-item">
                            <strong>بانک:</strong> {{ $b->bank_name }} &nbsp;&nbsp;
                            <strong>شماره حساب:</strong> {{ $b->account_number }} &nbsp;&nbsp;
                            <strong>کارت:</strong> {{ $b->card_number }} &nbsp;&nbsp;
                            <strong>شبا:</strong> {{ $b->iban }}
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <span class="text-muted">هیچ حساب بانکی ثبت نشده است.</span>
                    @endif
                </div>
            </div>
        </div>
        <!-- تاریخ‌ها -->
        <div class="accordion-item tree-node">
            <h2 class="accordion-header" id="dateInfoHeading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#dateInfo" aria-expanded="false" aria-controls="dateInfo">
                    <i class="bi bi-calendar"></i> تاریخ‌ها
                </button>
            </h2>
            <div id="dateInfo" class="accordion-collapse collapse" aria-labelledby="dateInfoHeading" data-bs-parent="#sellerInfoTree">
                <div class="accordion-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>تاریخ تولد:</strong> {{ $seller->birth_date }}</li>
                        <li class="list-group-item"><strong>تاریخ ازدواج:</strong> {{ $seller->marriage_date }}</li>
                        <li class="list-group-item"><strong>تاریخ عضویت:</strong> {{ $seller->join_date }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
