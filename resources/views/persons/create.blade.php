@extends('layouts.app')

@section('title', 'ایجاد شخص جدید')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/persian-datepicker@latest/dist/css/persian-datepicker.min.css">
<link rel="stylesheet" href="{{ asset('css/person-create.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid large-form-container">
    <div class="row justify-content-center">
        <div class="col-12">

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

            <form id="person-form" action="{{ route('persons.store') }}" method="POST" class="animate-fade-in" novalidate>
                @csrf

                <!-- اطلاعات اصلی -->
                <div class="card">
                    <div class="card-header main-info">
                        <h5><i class="fas fa-user section-icon"></i>اطلاعات اصلی</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- کد حسابداری -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label required-field">کد حسابداری</label>
                                    <div id="accounting_code_container">
                                        <div class="accounting-code-container">
                                            <input type="text" name="accounting_code"
                                                   id="accounting_code"
                                                   class="form-control @error('accounting_code') is-invalid @enderror"
                                                   value="{{ old('accounting_code') }}"
                                                   required {{ old('auto_code', '1') === '1' ? 'readonly' : '' }}>
                                            <label class="switch">
                                                <input type="checkbox" id="autoCodeSwitch" name="auto_code"
                                                       value="1" {{ old('auto_code', '1') === '1' ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                            <span class="accounting-code-label">کد خودکار</span>
                                        </div>
                                    </div>
                                    @error('accounting_code')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- شرکت -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">شرکت</label>
                                    <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}">
                                </div>
                            </div>
                            <!-- عنوان -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">عنوان</label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                                </div>
                            </div>
                            <!-- نوع -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label required-field">نوع</label>
                                    <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                                        <option value="">انتخاب کنید</option>
                                        <option value="customer" {{ old('type') == 'customer' ? 'selected' : '' }}>مشتری</option>
                                        <option value="supplier" {{ old('type') == 'supplier' ? 'selected' : '' }}>تامین کننده</option>
                                        <option value="shareholder" {{ old('type') == 'shareholder' ? 'selected' : '' }}>سهامدار</option>
                                        <option value="employee" {{ old('type') == 'employee' ? 'selected' : '' }}>کارمند</option>
                                    </select>
                                    @error('type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- نام -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label required-field">نام</label>
                                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                                           value="{{ old('first_name') }}" required>
                                    @error('first_name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- نام خانوادگی -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label required-field">نام خانوادگی</label>
                                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                                           value="{{ old('last_name') }}" required>
                                    @error('last_name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- نام مستعار -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">نام مستعار</label>
                                    <input type="text" name="nickname" class="form-control"
                                           value="{{ old('nickname') }}">
                                </div>
                            </div>
                            <!-- دسته‌بندی (Select2 AJAX) -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">دسته‌بندی</label>
                                    <select id="category_select" name="category_id" class="form-control">
                                        @if(old('category_id') && old('category_text'))
                                            <option value="{{ old('category_id') }}" selected>{{ old('category_text') }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- اطلاعات عمومی -->
                <div class="card">
                    <div class="card-header general-info">
                        <h5><i class="fas fa-info-circle section-icon"></i>اطلاعات عمومی</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">اعتبار مالی (ریال)</label>
                                    <input type="number" name="credit_limit" class="form-control" value="{{ old('credit_limit', 0) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">لیست قیمت</label>
                                    <input type="text" name="price_list" class="form-control" value="{{ old('price_list') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">نوع مالیات</label>
                                    <input type="text" name="tax_type" class="form-control" value="{{ old('tax_type') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">کد ملی</label>
                                    <input type="text" name="national_code" class="form-control @error('national_code') is-invalid @enderror"
                                           value="{{ old('national_code') }}" maxlength="10" pattern="\d{10}">
                                    @error('national_code')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- سایر فیلدها... -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">کد اقتصادی</label>
                                    <input type="text" name="economic_code" class="form-control" value="{{ old('economic_code') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">شماره ثبت</label>
                                    <input type="text" name="registration_number" class="form-control" value="{{ old('registration_number') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">کد شعبه</label>
                                    <input type="text" name="branch_code" class="form-control" value="{{ old('branch_code') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">توضیحات</label>
                                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- آدرس -->
                <div class="card">
                    <div class="card-header address-info">
                        <h5><i class="fas fa-map-marker-alt section-icon"></i>آدرس</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label required-field">آدرس کامل</label>
                                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" required>{{ old('address') }}</textarea>
                                    @error('address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label required-field">کشور</label>
                                    <input type="text" name="country" class="form-control @error('country') is-invalid @enderror"
                                           value="{{ old('country', 'ایران') }}" required>
                                    @error('country')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label required-field">استان</label>
                                    <select id="province_select" name="province"
                                            class="form-control @error('province') is-invalid @enderror" required data-old-value="{{ old('province') }}">
                                        <option value="">انتخاب استان</option>
                                        @foreach($provinces as $prov)
                                            <option value="{{ $prov->id }}" {{ old('province') == $prov->id ? 'selected' : '' }}>
                                                {{ $prov->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('province')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label required-field">شهر</label>
                                    <select id="city_select" name="city" class="form-control @error('city') is-invalid @enderror" required>
                                        <option value="">ابتدا استان را انتخاب کنید</option>
                                    </select>
                                    @error('city')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">کد پستی</label>
                                    <input type="text" name="postal_code" class="form-control"
                                           value="{{ old('postal_code') }}" maxlength="10" pattern="\d{10}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- اطلاعات تماس -->
                <div class="card">
                    <div class="card-header contact-info">
                        <h5><i class="fas fa-phone section-icon"></i>اطلاعات تماس</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">تلفن</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">موبایل</label>
                                    <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">فکس</label>
                                    <input type="text" name="fax" class="form-control" value="{{ old('fax') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">تلفن ۱</label>
                                    <input type="text" name="phone1" class="form-control" value="{{ old('phone1') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">تلفن ۲</label>
                                    <input type="text" name="phone2" class="form-control" value="{{ old('phone2') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">تلفن ۳</label>
                                    <input type="text" name="phone3" class="form-control" value="{{ old('phone3') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">ایمیل</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">وب سایت</label>
                                    <input type="url" name="website" class="form-control" value="{{ old('website') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- حساب‌های بانکی -->
                <div class="card">
                    <div class="card-header bank-info">
                        <h5 class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-university section-icon"></i>حساب‌های بانکی</span>
                            <button type="button" class="btn btn-light" id="add-bank-account">
                                <i class="fas fa-plus"></i> افزودن حساب بانکی
                            </button>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="bank-accounts">
                            @if(old('bank_accounts'))
                                @foreach(old('bank_accounts') as $idx => $account)
                                    <div class="bank-account-row mb-3 border rounded p-2" data-index="{{ $idx }}">
                                        <div class="form-row">
                                            <div class="col-md-2 mb-2">
                                                <input type="text" name="bank_accounts[{{ $idx }}][bank_name]" class="form-control" placeholder="نام بانک"
                                                    value="{{ $account['bank_name'] ?? '' }}">
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <input type="text" name="bank_accounts[{{ $idx }}][branch]" class="form-control" placeholder="شعبه"
                                                    value="{{ $account['branch'] ?? '' }}">
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <input type="text" name="bank_accounts[{{ $idx }}][account_number]" class="form-control" placeholder="شماره حساب"
                                                    value="{{ $account['account_number'] ?? '' }}">
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <input type="text" name="bank_accounts[{{ $idx }}][card_number]" class="form-control" placeholder="شماره کارت"
                                                    value="{{ $account['card_number'] ?? '' }}">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <input type="text" name="bank_accounts[{{ $idx }}][iban]" class="form-control" placeholder="شماره شبا"
                                                    value="{{ $account['iban'] ?? '' }}">
                                            </div>
                                            <div class="col-md-1 mb-2 d-flex align-items-center">
                                                <button type="button" class="btn btn-danger btn-sm remove-bank-account" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!-- تاریخ‌ها -->
                <div class="card">
                    <div class="card-header date-info">
                        <h5><i class="fas fa-calendar section-icon"></i>تاریخ‌ها</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">تاریخ تولد</label>
                                    <input type="text" name="birth_date" class="form-control datepicker" value="{{ old('birth_date') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">تاریخ ازدواج</label>
                                    <input type="text" name="marriage_date" class="form-control datepicker" value="{{ old('marriage_date') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label required-field">تاریخ عضویت</label>
                                    <input type="text" name="join_date" class="form-control datepicker"
                                           value="{{ old('join_date', date('Y-m-d')) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- دکمه‌های فرم -->
                <div class="form-actions text-left mt-4">
                    <button type="submit" class="btn btn-primary ml-2">
                        <i class="fas fa-save"></i> ذخیره
                    </button>
                    <a href="{{ route('persons.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> انصراف
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://unpkg.com/persian-date@latest/dist/persian-date.min.js"></script>
<script src="https://unpkg.com/persian-datepicker@latest/dist/js/persian-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // دسته‌بندی (Select2 Ajax)
    $('#category_select').select2({
        placeholder: 'انتخاب یا جستجوی دسته‌بندی شخص',
        ajax: {
            url: '{{ route("categories.person-search") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return { results: data.slice(0, 5) };
            },
            cache: true
        },
        minimumInputLength: 0,
        language: {
            noResults: function () {
                return "دسته‌بندی یافت نشد";
            }
        }
    });

    // اگر دسته‌بندی قبلاً انتخاب شده بود (برای old)، مقدار اولیه را تنظیم کن
    @if(old('category_id') && old('category_text'))
        var option = new Option("{{ old('category_text') }}", "{{ old('category_id') }}", true, true);
        $('#category_select').append(option).trigger('change');
    @endif

    // کد حسابداری: فعال/غیرفعال کردن readonly و درخواست کد خودکار
    $('#autoCodeSwitch').on('change', function() {
        if ($(this).is(':checked')) {
            $('#accounting_code').prop('readonly', true);
            // درخواست کد خودکار از سرور
            $.get('{{ route("persons.next-code") }}', function(data) {
                $('#accounting_code').val(data.code);
            });
        } else {
            $('#accounting_code').prop('readonly', false);
        }
    });

    // اگر کد خودکار فعال است و مقدار ندارد، از سرور بگیر!
    @if(old('auto_code', '1') === '1' && !old('accounting_code'))
        $.get('{{ route("persons.next-code") }}', function(data) {
            $('#accounting_code').val(data.code);
        });
    @endif

    // استان و شهر وابسته
    $('#province_select').on('change', function() {
        let provinceId = $(this).val();
        $('#city_select').empty().append('<option value="">در حال بارگذاری...</option>');
        if (provinceId) {
            $.getJSON('/provinces/' + provinceId + '/cities', function (data) {
                let items = '<option value="">انتخاب شهر</option>';
                $.each(data, function (i, city) {
                    let selected = '';
                    @if(!old('city'))
                        // مقدار پیش‌فرض نقاب
                        if(provinceId == 11 && city.id == 1106) selected = 'selected';
                    @endif
                    items += `<option value="${city.id}" ${selected}>${city.name}</option>`;
                });
                $('#city_select').html(items);
            }).fail(function () {
                $('#city_select').html('<option value="">خطا در دریافت شهرها</option>');
            });
        } else {
            $('#city_select').html('<option value="">ابتدا استان را انتخاب کنید</option>');
        }
    });

    // اگر old استان و شهر داری، شهرها را لود کن
    @if(old('province'))
        $.getJSON('/provinces/{{ old('province') }}/cities', function(data){
            let items = '<option value="">انتخاب شهر</option>';
            $.each(data, function(i, city){
                let selected = ({{ old('city') ?: 0 }} == city.id) ? 'selected' : '';
                items += `<option value="${city.id}" ${selected}>${city.name}</option>`;
            });
            $('#city_select').html(items);
        });
    @endif

    // تاریخ شمسی
    $('.datepicker').persianDatepicker({
    format: 'YYYY-MM-DD',
    initialValue: false,
    autoClose: true,
    toolbox: {
        calendarSwitch: { enabled: false },
        todayButton: { enabled: true },
        submitButton: { enabled: true }
    }
});

    // حساب بانکی داینامیک
    let bankAccountIndex = $('#bank-accounts .bank-account-row').length || 0;
    $('#add-bank-account').on('click', function() {
        bankAccountIndex++;
        let bankAccountHtml = `
            <div class="bank-account-row mb-3 border rounded p-2" data-index="${bankAccountIndex}">
                <div class="form-row">
                    <div class="col-md-2 mb-2">
                        <input type="text" name="bank_accounts[${bankAccountIndex}][bank_name]" class="form-control" placeholder="نام بانک">
                    </div>
                    <div class="col-md-2 mb-2">
                        <input type="text" name="bank_accounts[${bankAccountIndex}][branch]" class="form-control" placeholder="شعبه">
                    </div>
                    <div class="col-md-2 mb-2">
                        <input type="text" name="bank_accounts[${bankAccountIndex}][account_number]" class="form-control" placeholder="شماره حساب">
                    </div>
                    <div class="col-md-2 mb-2">
                        <input type="text" name="bank_accounts[${bankAccountIndex}][card_number]" class="form-control" placeholder="شماره کارت">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="text" name="bank_accounts[${bankAccountIndex}][iban]" class="form-control" placeholder="شماره شبا">
                    </div>
                    <div class="col-md-1 mb-2 d-flex align-items-center">
                        <button type="button" class="btn btn-danger btn-sm remove-bank-account" title="حذف">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        $('#bank-accounts').append(bankAccountHtml);
    });
    $(document).on('click', '.remove-bank-account', function() {
        $(this).closest('.bank-account-row').remove();
    });

    // نمایش ارور قرمز کنار فیلدهای الزامی (فرانت)
    $('#person-form').on('submit', function(e) {
        let isValid = true;
        $(this).find('[required]').each(function(){
            if(!$(this).val() || $(this).val().trim() === ''){
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        if(!isValid) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $(".is-invalid:first").offset().top - 100
            }, 500);
        }
    });
    $('input, select, textarea').on('input change', function(){
        if($(this).val().trim() !== '') {
            $(this).removeClass('is-invalid');
        }
    });
});
</script>
@endpush
