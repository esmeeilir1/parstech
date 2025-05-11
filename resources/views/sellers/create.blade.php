@extends('layouts.app')

@section('title', 'فروشنده جدید')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('css/person-create.css') }}">
    <link rel="stylesheet" href="{{ asset('css/seller-create.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h3 class="mb-4">ایجاد فروشنده جدید</h3>
            <form method="POST" action="{{ route('sellers.store') }}" enctype="multipart/form-data" autocomplete="off">
                @csrf

                <ul class="nav nav-tabs" id="sellerTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#main-info">اطلاعات اصلی</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#general-info">عمومی</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#contact-info">تماس</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#address-info">آدرس</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#bank-info">بانک و کارت</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#date-info">تاریخ</a></li>
                </ul>
                <div class="tab-content pt-4">
                    <!-- تب اطلاعات اصلی -->
                    <div class="tab-pane fade show active" id="main-info">
                        <div class="row">
                            <div class="col-md-2 text-center">
                                <img id="seller_img_preview" src="{{ asset('img/user-default.png') }}" class="img-thumbnail mb-2" style="width:120px">
                                <input type="file" name="image" id="seller_image" class="form-control" accept="image/*" onchange="readURL(this)">
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label>کد فروشنده</label>
                                        <div class="input-group">
                                            <input type="text" name="seller_code" id="seller_code" class="form-control" value="{{ old('seller_code', $nextCode) }}" readonly required>
                                            <button type="button" class="btn btn-outline-secondary" id="toggleSellerCodeEdit">اجازه ویرایش دستی</button>
                                        </div>
                                        @error('seller_code')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label>نام</label>
                                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label>نام خانوادگی</label>
                                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label>نام مستعار</label>
                                        <input type="text" name="nickname" class="form-control" value="{{ old('nickname') }}">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label>شرکت</label>
                                        <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label>عنوان</label>
                                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- تب اطلاعات عمومی -->
                    <div class="tab-pane fade" id="general-info">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label>اعتبار مالی</label>
                                <input type="number" name="credit_limit" class="form-control" value="{{ old('credit_limit') }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>لیست قیمت</label>
                                <input type="text" name="price_list" class="form-control" value="{{ old('price_list') }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>نوع مالیات</label>
                                <input type="text" name="tax_type" class="form-control" value="{{ old('tax_type') }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>کد ملی</label>
                                <input type="text" name="national_code" class="form-control" value="{{ old('national_code') }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>کد اقتصادی</label>
                                <input type="text" name="economic_code" class="form-control" value="{{ old('economic_code') }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>شماره ثبت</label>
                                <input type="text" name="registration_number" class="form-control" value="{{ old('registration_number') }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>کد شعبه</label>
                                <input type="text" name="branch_code" class="form-control" value="{{ old('branch_code') }}">
                            </div>
                            <div class="col-md-8 mb-2">
                                <label>توضیحات</label>
                                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- تب تماس -->
                    <div class="tab-pane fade" id="contact-info">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label>تلفن</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>موبایل</label>
                                <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>ایمیل</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>وب‌سایت</label>
                                <input type="text" name="website" class="form-control" value="{{ old('website') }}">
                            </div>
                        </div>
                    </div>
                    <!-- تب آدرس -->
                    <div class="tab-pane fade" id="address-info">
                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <label>کشور</label>
                                <input type="text" name="country" class="form-control" value="{{ old('country') }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>استان</label>
                                <input type="text" name="province" class="form-control" value="{{ old('province') }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>شهر</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city') }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>کدپستی</label>
                                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code') }}">
                            </div>
                            <div class="col-md-12 mb-2">
                                <label>آدرس</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                            </div>
                        </div>
                    </div>
                    <!-- تب بانک و کارت -->
                    <div class="tab-pane fade" id="bank-info">
                        <div id="bank-accounts-container">
                            <!-- این بخش با جاوااسکریپت داینامیک می‌شود -->
                        </div>
                        <button type="button" id="add-bank-account" class="btn btn-success btn-sm mt-2">افزودن حساب بانکی</button>
                    </div>
                    <!-- تب تاریخ -->
                    <div class="tab-pane fade" id="date-info">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label>تاریخ تولد</label>
                                <input type="text" name="birth_date" class="form-control datepicker" value="{{ old('birth_date') }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>تاریخ ازدواج</label>
                                <input type="text" name="marriage_date" class="form-control datepicker" value="{{ old('marriage_date') }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>تاریخ عضویت</label>
                                <input type="text" name="join_date" class="form-control datepicker" value="{{ old('join_date') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions text-left mt-4">
                    <button type="submit" class="btn btn-primary ml-2">
                        <i class="fas fa-save"></i> ذخیره
                    </button>
                    <a href="{{ route('sellers.index') }}" class="btn btn-secondary">
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
    // فعال/غیرفعال کردن ویرایش کد فروشنده
    $('#toggleSellerCodeEdit').on('click', function() {
        let input = $('#seller_code');
        input.prop('readonly', !input.prop('readonly'));
        if (input.prop('readonly')) {
            $.get('{{ route("sellers.next-code") }}', function(data) {
                input.val(data.code);
            });
        }
    });

    // پیش‌نمایش تصویر
    window.readURL = function(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#seller_img_preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // تقویم شمسی
    $('.datepicker').persianDatepicker({
        format: 'YYYY/MM/DD',
        autoClose: true,
        initialValue: false,
        persianDigit: false
    });

    // افزودن حساب بانکی به صورت داینامیک (نمونه)
    $('#add-bank-account').on('click', function() {
        let html = `<div class="bank-account-row row mb-2">
            <div class="col-md-3"><input type="text" name="bank_accounts[bank_name][]" class="form-control" placeholder="بانک"></div>
            <div class="col-md-3"><input type="text" name="bank_accounts[account_number][]" class="form-control" placeholder="شماره حساب"></div>
            <div class="col-md-2"><input type="text" name="bank_accounts[card_number][]" class="form-control" placeholder="شماره کارت"></div>
            <div class="col-md-3"><input type="text" name="bank_accounts[iban][]" class="form-control" placeholder="شبا"></div>
            <div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-bank-account">&times;</button></div>
        </div>`;
        $('#bank-accounts-container').append(html);
    });
    // حذف حساب بانکی
    $(document).on('click', '.remove-bank-account', function() {
        $(this).closest('.bank-account-row').remove();
    });
</script>
@endpush
