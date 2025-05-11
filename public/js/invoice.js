$(document).ready(function () {
    // راه‌اندازی تقویم شمسی
    let datePickerConfig = {
        initialValue: true,
        initialValueType: 'persian',
        format: 'YYYY/MM/DD',
        autoClose: true,
        persianDigit: true,
        observer: true,
        calendar: { persian: { locale: 'fa' } },
        toolbox: { calendarSwitch: { enabled: false } },
        onSelect: function () {
            $(this.model.inputElement).trigger('change');
        }
    };
    $('#date, #dueDate').persianDatepicker(datePickerConfig);

    // سلکت مشتری و فروشنده با AJAX (Select2)
    $('.select2').select2({
        theme: 'bootstrap4',
        dir: 'rtl',
        language: 'fa',
        placeholder: 'انتخاب کنید...',
        allowClear: true,
        ajax: {
            url: function () {
                const type = $(this).attr('id');
                return `/api/${type}s/search`;
            },
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page || 1
                };
            },
            processResults: function (data) {
                return {
                    results: data.items,
                    pagination: { more: data.hasMore }
                };
            },
            cache: true
        },
        minimumInputLength: 2,
        // مقادیر اولیه برای old value
        initSelection: function (element, callback) {
            let id = $(element).val();
            if (id) {
                let type = $(element).attr('id');
                $.ajax({
                    url: `/api/${type}s/${id}`,
                    dataType: 'json'
                }).done(function (data) {
                    callback({ id: data.id, text: data.name });
                });
            }
        }
    });

    // جستجوی محصولات با دیبونس
    let searchTimeout;
    $('#productSearch').on('input', function () {
        const query = $(this).val();
        const $productList = $('#productList');
        clearTimeout(searchTimeout);

        if (query.length < 2) {
            $productList.hide().empty();
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch(`/api/products/search?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(products => {
                    $productList.empty();
                    if (products.length === 0) {
                        $productList.append(`<div class="p-3 text-center text-muted">محصولی یافت نشد</div>`);
                    } else {
                        products.forEach(product => {
                            const productHtml = `
                                <div class="product-item">
                                    <img src="${product.image || '/images/no-image.png'}"
                                         class="product-image"
                                         alt="${product.name}">
                                    <div class="product-info">
                                        <div class="product-name">${product.name}</div>
                                        <div class="product-code">${product.code}</div>
                                    </div>
                                    <button type="button"
                                            class="btn btn-primary btn-sm add-product-btn"
                                            data-product='${JSON.stringify(product)}'>
                                        افزودن
                                    </button>
                                </div>
                            `;
                            $productList.append(productHtml);
                        });
                    }
                    $productList.show();
                });
        }, 300);
    });

    // افزودن محصول به جدول
    $(document).on('click', '.add-product-btn', function () {
        let product = $(this).data('product');
        if (typeof product === "string") product = JSON.parse(product);

        const $selectedProducts = $('#selectedProducts');
        const existingRow = $selectedProducts.find(`[data-product-id="${product.id}"]`);

        if (existingRow.length) {
            const quantityInput = existingRow.find('input[name$="[quantity]"]');
            quantityInput.val(parseInt(quantityInput.val()) + 1).trigger('change');
            $('#productList').hide();
            $('#productSearch').val('');
            return;
        }

        const rowHtml = `
            <tr data-product-id="${product.id}">
                <td>
                    <img src="${product.image || '/images/no-image.png'}"
                         alt="${product.name}"
                         width="50" height="50"
                         style="object-fit: cover; border-radius: 4px;">
                </td>
                <td>${product.code}</td>
                <td>${product.name}</td>
                <td>${product.category}</td>
                <td class="${product.stock < 10 ? 'low-stock' : ''}">${product.stock}</td>
                <td>
                    <input type="number"
                           class="form-control text-left"
                           name="products[${product.id}][price]"
                           value="${product.price}"
                           min="0"
                           step="1000"
                           onchange="calculateRowTotal(this)">
                </td>
                <td>
                    <input type="number"
                           class="form-control text-left"
                           name="products[${product.id}][quantity]"
                           value="1"
                           min="1"
                           max="${product.stock}"
                           onchange="calculateRowTotal(this)">
                </td>
                <td class="row-total">${product.price}</td>
                <td>
                    <button type="button"
                            class="btn-remove"
                            onclick="removeProduct(this)">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        `;
        $selectedProducts.append(rowHtml);
        calculateTotals();
        $('#productList').hide();
        $('#productSearch').val('');
    });

    // بستن لیست محصولات با کلیک بیرون
    $(document).on('click', function (event) {
        if (!$(event.target).closest('.product-search-container').length) {
            $('#productList').hide();
        }
    });

    // محاسبه مجموع هر ردیف و کل
    $(document).on('input', 'input[name*="[quantity]"], input[name*="[price]"]', function () {
        calculateRowTotal(this);
    });

    $('#discount').on('input', calculateTotals);

    // تابع حذف محصول
    window.removeProduct = function (button) {
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            text: "این محصول از لیست حذف خواهد شد",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'بله، حذف شود',
            cancelButtonText: 'انصراف'
        }).then((result) => {
            if (result.isConfirmed) {
                $(button).closest('tr').remove();
                calculateTotals();
            }
        });
    };

    // تابع محاسبه مجموع هر ردیف
    window.calculateRowTotal = function (input) {
        const row = $(input).closest('tr');
        const price = parseFloat(row.find('input[name$="[price]"]').val()) || 0;
        const quantity = parseInt(row.find('input[name$="[quantity]"]').val()) || 0;
        const total = price * quantity;
        row.find('.row-total').text(total.toLocaleString('fa-IR'));
        calculateTotals();
    };

    // تابع محاسبه مجموع کل فاکتور
    window.calculateTotals = function () {
        let total = 0;
        $('#selectedProducts tr').each(function () {
            total += parseInt($(this).find('.row-total').text().replace(/,/g, '')) || 0;
        });
        const discount = parseFloat($('#discount').val()) || 0;
        const discountAmount = (total * discount) / 100;
        const finalAmount = total - discountAmount;

        $('#totalAmount').text(total.toLocaleString('fa-IR'));
        $('#discountAmount').text(discountAmount.toLocaleString('fa-IR'));
        $('#finalAmount').text(finalAmount.toLocaleString('fa-IR'));
    };

    // تغییر حالت شماره فاکتور
    window.toggleInvoiceNumber = function () {
        const $invoiceNumber = $('#invoiceNumber');
        const isManual = $('#invoiceNumberSwitch').is(':checked');
        $invoiceNumber.prop('readonly', !isManual); // فعال/غیرفعال کردن حالت ویرایش

        if (!isManual) {
            // تنظیم شماره فاکتور به صورت پیش‌فرض
            $invoiceNumber.val('invoices-10001');
        } else {
            // خالی کردن فیلد برای شماره‌گذاری دستی
            $invoiceNumber.val('').focus();
        }
    };

    // اعتبارسنجی فرم قبل از ارسال
    $('#invoiceForm').on('submit', function (e) {
        if (!$('#selectedProducts tr').length) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'خطا',
                text: 'لطفاً حداقل یک محصول به فاکتور اضافه کنید'
            });
            return false;
        }
        if (!$('#customer').val()) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'خطا',
                text: 'لطفاً مشتری را انتخاب کنید'
            });
            return false;
        }

        // غیر فعال کردن دکمه ثبت پس از کلیک
        $(this).find('button[type="submit"]').attr('disabled', true);
    });

    $('#customer').select2({
    theme: 'bootstrap4',
    dir: 'rtl',
    language: 'fa',
    placeholder: 'انتخاب مشتری...',
    ajax: {
        url: '/api/customers/search',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                term: params.term, // کلمه جستجو
            };
        },
        processResults: function (data) {
            return {
                results: data,
            };
        },
        cache: true,
    },
    });
    $(document).ready(function () {
    // راه‌اندازی تقویم شمسی
    $('#date').persianDatepicker({
    format: 'YYYY/MM/DD',
    autoClose: true,
    initialValue: true,
    persianDigit: true
    });

    // جستجوی محصولات
    $('#productSearch').on('input', function () {
        let query = $(this).val();
        if (query.length < 2) {
            $('#productList').hide().empty();
            return;
        }

        $.get(`/api/products/search?q=${query}`, function (data) {
            let productList = data.map(product => `
                <div class="product-item">
                    <img src="${product.image}" class="product-image" alt="${product.name}">
                    <div>
                        <div>${product.name}</div>
                        <small>${product.code}</small>
                    </div>
                </div>
            `);
            $('#productList').html(productList.join('')).show();
        });
    });
});
});
