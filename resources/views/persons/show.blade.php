@extends('layouts.app')

@section('title', 'نمایش اطلاعات شخص')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/persons/show.css') }}">
@endpush

@section('content')
<div class="container py-4">
    <h2 class="mb-4">نمایش اطلاعات شخص</h2>
    <div class="mb-3">
        <a href="{{ route('persons.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-right"></i> بازگشت به لیست</a>
        <a href="{{ route('persons.edit', $person) }}" class="btn btn-warning"><i class="bi bi-pencil-square"></i> ویرایش</a>
    </div>

    <div class="accordion" id="personInfoTree">
        <!-- اطلاعات اصلی -->
        <div class="accordion-item tree-node">
            <h2 class="accordion-header" id="mainInfoHeading">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#mainInfo" aria-expanded="true" aria-controls="mainInfo">
                    <span class="tree-title"><i class="bi bi-person"></i> اطلاعات اصلی</span>
                </button>
            </h2>
            <div id="mainInfo" class="accordion-collapse collapse show" aria-labelledby="mainInfoHeading" data-bs-parent="#personInfoTree">
                <div class="accordion-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>کد حسابداری:</strong> {{ $person->accounting_code }}</li>
                        <li class="list-group-item"><strong>نوع:</strong> {{ $person->type }}</li>
                        <li class="list-group-item"><strong>نام:</strong> {{ $person->first_name }}</li>
                        <li class="list-group-item"><strong>نام خانوادگی:</strong> {{ $person->last_name }}</li>
                        @if($person->company_name)
                        <li class="list-group-item"><strong>شرکت:</strong> {{ $person->company_name }}</li>
                        @endif
                        @if($person->title)
                        <li class="list-group-item"><strong>عنوان:</strong> {{ $person->title }}</li>
                        @endif
                        @if($person->nickname)
                        <li class="list-group-item"><strong>نام مستعار:</strong> {{ $person->nickname }}</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- اطلاعات عمومی -->
        <div class="accordion-item tree-node">
            <h2 class="accordion-header" id="generalInfoHeading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#generalInfo" aria-expanded="false" aria-controls="generalInfo">
                    <span class="tree-title"><i class="bi bi-info-circle"></i> اطلاعات عمومی</span>
                </button>
            </h2>
            <div id="generalInfo" class="accordion-collapse collapse" aria-labelledby="generalInfoHeading" data-bs-parent="#personInfoTree">
                <div class="accordion-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>اعتبار مالی:</strong> {{ number_format($person->credit_limit) }} ریال</li>
                        <li class="list-group-item"><strong>لیست قیمت:</strong> {{ $person->price_list }}</li>
                        <li class="list-group-item"><strong>نوع مالیات:</strong> {{ $person->tax_type }}</li>
                        <li class="list-group-item"><strong>کد ملی:</strong> {{ $person->national_code }}</li>
                        <li class="list-group-item"><strong>کد اقتصادی:</strong> {{ $person->economic_code }}</li>
                        <li class="list-group-item"><strong>شماره ثبت:</strong> {{ $person->registration_number }}</li>
                        <li class="list-group-item"><strong>کد شعبه:</strong> {{ $person->branch_code }}</li>
                        @if($person->description)
                        <li class="list-group-item"><strong>توضیحات:</strong> {{ $person->description }}</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- آدرس و مکان -->
        <div class="accordion-item tree-node">
            <h2 class="accordion-header" id="addressHeading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#addressInfo" aria-expanded="false" aria-controls="addressInfo">
                    <span class="tree-title"><i class="bi bi-geo-alt"></i> آدرس و مکان</span>
                </button>
            </h2>
            <div id="addressInfo" class="accordion-collapse collapse" aria-labelledby="addressHeading" data-bs-parent="#personInfoTree">
                <div class="accordion-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>آدرس:</strong> {{ $person->address }}</li>
                        <li class="list-group-item"><strong>کشور:</strong> {{ $person->country }}</li>
                        <li class="list-group-item"><strong>استان:</strong> {{ optional($person->provinceRel)->name ?? $person->province }}</li>
                        <li class="list-group-item"><strong>شهر:</strong> {{ optional($person->cityRel)->name ?? $person->city }}</li>
                        <li class="list-group-item"><strong>کد پستی:</strong> {{ $person->postal_code }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- اطلاعات تماس -->
        <div class="accordion-item tree-node">
            <h2 class="accordion-header" id="contactHeading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#contactInfo" aria-expanded="false" aria-controls="contactInfo">
                    <span class="tree-title"><i class="bi bi-telephone"></i> اطلاعات تماس</span>
                </button>
            </h2>
            <div id="contactInfo" class="accordion-collapse collapse" aria-labelledby="contactHeading" data-bs-parent="#personInfoTree">
                <div class="accordion-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>تلفن:</strong> {{ $person->phone }}</li>
                        <li class="list-group-item"><strong>موبایل:</strong> {{ $person->mobile }}</li>
                        <li class="list-group-item"><strong>فکس:</strong> {{ $person->fax }}</li>
                        <li class="list-group-item"><strong>تلفن ۱:</strong> {{ $person->phone1 }}</li>
                        <li class="list-group-item"><strong>تلفن ۲:</strong> {{ $person->phone2 }}</li>
                        <li class="list-group-item"><strong>تلفن ۳:</strong> {{ $person->phone3 }}</li>
                        <li class="list-group-item"><strong>ایمیل:</strong> {{ $person->email }}</li>
                        <li class="list-group-item"><strong>وب‌سایت:</strong> {{ $person->website }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- اطلاعات حساب بانکی -->
        @if($person->bankAccounts && count($person->bankAccounts))
        <div class="accordion-item tree-node">
            <h2 class="accordion-header" id="bankHeading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#bankInfo" aria-expanded="false" aria-controls="bankInfo">
                    <span class="tree-title"><i class="bi bi-bank"></i> حساب‌های بانکی</span>
                </button>
            </h2>
            <div id="bankInfo" class="accordion-collapse collapse" aria-labelledby="bankHeading" data-bs-parent="#personInfoTree">
                <div class="accordion-body">
                    <ul class="list-group bank-accounts">
                        @foreach($person->bankAccounts as $idx => $acc)
                            <li class="list-group-item bank-account">
                                <div class="bank-info">
                                    <strong>بانک:</strong> {{ $acc->bank_name }}
                                </div>
                                <div class="branch-info">
                                    <strong>شعبه:</strong> {{ $acc->branch ?? '-' }}
                                </div>
                                <div class="account-numbers">
                                    <div><strong>شماره حساب:</strong> {{ $acc->account_number }}</div>
                                    <div><strong>کارت:</strong> {{ $acc->card_number }}</div>
                                    <div><strong>شبا:</strong> {{ $acc->iban }}</div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- تاریخ‌ها -->
<div class="accordion-item tree-node">
    <h2 class="accordion-header" id="dateHeading">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#dateInfo" aria-expanded="false" aria-controls="dateInfo">
            <span class="tree-title"><i class="bi bi-calendar"></i> تاریخ‌ها</span>
        </button>
    </h2>
    <div id="dateInfo" class="accordion-collapse collapse" aria-labelledby="dateHeading" data-bs-parent="#personInfoTree">
        <div class="accordion-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <strong>تاریخ تولد:</strong>
                    {{ $person->birth_date ? \Morilog\Jalali\Jalalian::fromCarbon(\Carbon\Carbon::parse($person->birth_date))->format('Y/m/d') : 'ثبت نشده' }}
                </li>
                <li class="list-group-item">
                    <strong>تاریخ ازدواج:</strong>
                    {{ $person->marriage_date ? \Morilog\Jalali\Jalalian::fromCarbon(\Carbon\Carbon::parse($person->marriage_date))->format('Y/m/d') : 'ثبت نشده' }}
                </li>
                <li class="list-group-item">
                    <strong>تاریخ عضویت:</strong>
                    {{ $person->join_date ? \Morilog\Jalali\Jalalian::fromCarbon(\Carbon\Carbon::parse($person->join_date))->format('Y/m/d') : 'ثبت نشده' }}
                </li>
            </ul>
        </div>
    </div>
</div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/persons/show.js') }}"></script>
@endpush
