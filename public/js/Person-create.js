// تابع دریافت کد حسابداری بعدی (فقط کدهای عددی، نه شخصی‌سازی‌شده!)
function getNextCode() {
    $.ajax({
        url: '/api/persons/next-code',
        method: 'GET',
        success: function(response) {
            if (response.code) {
                $('#accounting_code').val(response.code);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching next code:', error);
            $('#accounting_code').val('person-10001');
        }
    });
}

$(document).ready(function () {
    // ساخت input و سوییچ کد حسابداری در ابتدای فرم
    const switchHtml = `
        <div class="accounting-code-container">
            <input type="text" name="accounting_code" id="accounting_code" class="form-control" required readonly>
            <label class="switch">
                <input type="checkbox" id="autoCodeSwitch" checked>
                <span class="slider"></span>
            </label>

        </div>
    `;
    $('#accounting_code_container').html(switchHtml);

    const $accountingCodeInput = $('#accounting_code');
    const $autoSwitch = $('#autoCodeSwitch');

    // مقداردهی اولیه اگر حالت خودکار است
    if ($autoSwitch.is(':checked')) {
        $accountingCodeInput.prop('readonly', true);
        getNextCode();
    }

    // رویداد تغییر سوییچ
    $autoSwitch.change(function() {
        if ($(this).is(':checked')) {
            $accountingCodeInput.prop('readonly', true);
            getNextCode();
        } else {
            $accountingCodeInput.prop('readonly', false);
            $accountingCodeInput.val('').focus();
        }
    });

    // تنظیمات تقویم شمسی
    $('.datepicker').persianDatepicker({
        format: 'YYYY/MM/DD',
        autoClose: true,
        initialValue: false,
        persianDigit: false
    });

    // افزودن حساب بانکی
    $('#add-bank-account').click(function() {
        const bankAccountHtml = `
            <div class="bank-account-row animate-fade-in">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">بانک</label>
                            <input type="text" name="bank_accounts[bank_name][]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">شماره حساب</label>
                            <input type="text" name="bank_accounts[account_number][]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">شماره کارت</label>
                            <input type="text" name="bank_accounts[card_number][]" class="form-control card-number" maxlength="19">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">شماره شبا</label>
                            <input type="text" name="bank_accounts[iban][]" class="form-control iban" maxlength="26">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-danger remove-bank-account">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('#bank-accounts').append(bankAccountHtml);
    });

    // حذف حساب بانکی
    $(document).on('click', '.remove-bank-account', function() {
        $(this).closest('.bank-account-row').fadeOut(300, function() {
            $(this).remove();
        });
    });

    // اعتبارسنجی کد ملی
    $('input[name="national_code"]').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 10) value = value.slice(0, 10);
        $(this).val(value);
    });

    // فرمت شماره کارت
    $(document).on('input', '.card-number', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 16) value = value.slice(0, 16);
        value = value.replace(/(\d{4})/g, '$1-').replace(/-$/, '');
        $(this).val(value);
    });

    // فرمت شماره شبا
    $(document).on('input', '.iban', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 24) value = value.slice(0, 24);
        if (value.length > 0) value = 'IR' + value;
        $(this).val(value);
    });

    // اعتبارسنجی فرم
    $('#person-form').on('submit', function(e) {
        let nationalCode = $('input[name="national_code"]').val();
        if (nationalCode && !validateNationalCode(nationalCode)) {
            e.preventDefault();
            alert('کد ملی وارد شده معتبر نیست');
        }

        // نمایش loading
        if ($(this).valid()) {
            $(this).addClass('loading');
            $('button[type="submit"]').prop('disabled', true);
        }
    });

    // تابع اعتبارسنجی کد ملی
    function validateNationalCode(code) {
        if (!/^\d{10}$/.test(code)) return false;

        const check = parseInt(code[9]);
        let sum = 0;
        for (let i = 0; i < 9; i++) {
            sum += parseInt(code[i]) * (10 - i);
        }
        const remainder = sum % 11;
        return (remainder < 2 && check == remainder) || (remainder >= 2 && check == 11 - remainder);
    }
});
// فعالسازی select2
$('#province_select, #city_select').select2({
    placeholder: 'انتخاب کنید',
    width: '100%'
});

// واکنش به تغییر استان
$('#province_select').on('change', function(){
    let provinceId = $(this).val();
    $('#city_select').empty().append('<option value="">در حال بارگذاری...</option>').trigger('change');
    if(provinceId) {
        $.getJSON('/provinces/' + provinceId + '/cities', function(data){
            let items = [{id: '', text: 'انتخاب شهر'}];
            $.each(data, function(i, city){
                items.push({id: city.id, text: city.text});
            });
            $('#city_select').empty().select2({
                data: items,
                placeholder: 'انتخاب شهر',
                width: '100%'
            });
        });
    } else {
        $('#city_select').empty().append('<option value="">ابتدا استان را انتخاب کنید</option>').trigger('change');
    }
});

// تنظیمات استان و شهر
function setupProvinceCity() {
    $('#province_select').on('change', function() {
        const provinceId = $(this).val();
        const citySelect = $('#city_select');

        if (provinceId) {
            $.get(`/provinces/${provinceId}/cities`, function(cities) {
                citySelect.empty();
                citySelect.append('<option value="">انتخاب شهر</option>');

                cities.forEach(function(city) {
                    citySelect.append(`<option value="${city.id}">${city.name}</option>`);
                });

                // اگر شهر قبلاً انتخاب شده بود
                const oldCity = citySelect.data('old-value');
                if (oldCity) {
                    citySelect.val(oldCity);
                }
            });
        } else {
            citySelect.empty();
            citySelect.append('<option value="">ابتدا استان را انتخاب کنید</option>');
        }
    });

    // اگر استان از قبل انتخاب شده بود
    const oldProvince = $('#province_select').data('old-value');
    if (oldProvince) {
        $('#province_select').val(oldProvince).trigger('change');
    }
}
// اضافه کردن به تابع اصلی
$(document).ready(function() {
    setupTabs();
    setupAccountingCode();
    setupCategorySelect();
    setupDatePickers();
    setupBankAccounts();
    setupProvinceCity(); // اضافه کردن این خط
});
