document.addEventListener('DOMContentLoaded', function() {
    // تنظیمات Select2
    initializeSelect2();

    // تنظیمات تاریخ شمسی
    initializeDatePickers();

    // مدیریت شماره فاکتور
    initializeInvoiceNumberToggle();

    // مدیریت جستجوی محصولات
    initializeProductSearch();

    // مدیریت محاسبات فاکتور
    function initializeInvoiceCalculations() {
    console.log("Invoice calculations initialized");
    // کدهای مربوط به محاسبات فاکتور را اینجا بنویسید
}
});
function toggleInvoiceNumber() {
    const $invoiceNumber = document.getElementById('invoiceNumber');
    const isManual = document.getElementById('invoiceNumberSwitch').checked;

    if (isManual) {
        // فعال کردن حالت دستی
        $invoiceNumber.readOnly = false;
        $invoiceNumber.value = ''; // خالی کردن شماره فاکتور برای وارد کردن دستی
        $invoiceNumber.focus();
    } else {
        // غیرفعال کردن حالت دستی و بازگرداندن مقدار پیش‌فرض
        $invoiceNumber.readOnly = true;
        $invoiceNumber.value = 'invoices-10001';
    }
}
function initializeSelect2() {
    // تنظیم Select2 برای مشتری
    $('#customer').select2({
        placeholder: 'مشتری را انتخاب کنید',
        ajax: {
            url: '/api/customers/search',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data.map(item => ({
                        id: item.id,
                        text: item.name
                    }))
                };
            }
        }
    });

    // تنظیم Select2 برای فروشنده
    $('#seller').select2({
        placeholder: 'فروشنده را انتخاب کنید',
        ajax: {
            url: '/api/sellers/search',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data.map(item => ({
                        id: item.id,
                        text: item.name
                    }))
                };
            }
        }
    });
}

function initializeDatePickers() {
    // تنظیم تقویم شمسی برای تاریخ فاکتور
    $('#date').persianDatepicker({
    format: 'YYYY/MM/DD',
    autoClose: true,
    initialValue: true,
    persianDigit: true
});

    // تنظیم تقویم شمسی برای تاریخ سررسید
    $('#dueDate').persianDatepicker({
    format: 'YYYY/MM/DD',
    autoClose: true,
    initialValue: true,
    persianDigit: true
});
}

function initializeInvoiceNumberToggle() {
    const invoiceNumberInput = document.getElementById('invoiceNumber');
    const invoiceNumberSwitch = document.getElementById('invoiceNumberSwitch');

    invoiceNumberSwitch.addEventListener('change', function() {
        invoiceNumberInput.readOnly = !this.checked;
        if (!this.checked) {
            // بازیابی شماره فاکتور خودکار
            fetch('/api/invoices/next-number')
                .then(response => response.json())
                .then(data => {
                    invoiceNumberInput.value = data.number;
                });
        }
    });
}

function initializeProductSearch() {
    const productSearch = document.getElementById('productSearch');
    const productList = document.getElementById('productList');
    let searchTimeout;

    productSearch.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();

        if (query.length < 0) {
            productList.style.display = 'none';
            return;
        }


    });
}

function displayProductResults(products) {
    const productList = document.getElementById('productList');
    productList.innerHTML = '';

    if (products.length === 0) {
        productList.style.display = 'none';
        return;
    }

    products.forEach(product => {
        const div = document.createElement('div');
        div.className = 'product-item';
        div.innerHTML = `
            <div class="product-info">
                <img src="${product.image}" alt="${product.name}" class="product-image">
                <div>
                    <strong>${product.name}</strong>
                    <div>کد: ${product.code}</div>
                    <div>موجودی: ${product.stock}</div>
                </div>
            </div>
            <div class="product-price">${formatNumber(product.price)} ریال</div>
        `;

        div.addEventListener('click', () => addProductToInvoice(product));
        productList.appendChild(div);
    });

    productList.style.display = 'block';
}

function addProductToInvoice(product) {
    const tbody = document.getElementById('selectedProducts');
    const existingRow = document.querySelector(`tr[data-product-id="${product.id}"]`);

    if (existingRow) {
        // افزایش تعداد محصول موجود
        const quantityInput = existingRow.querySelector('.quantity-input');
        quantityInput.value = parseInt(quantityInput.value) + 1;
        updateRowTotal(existingRow);
    } else {
        // افزودن ردیف جدید
        const tr = document.createElement('tr');
        tr.setAttribute('data-product-id', product.id);
        tr.innerHTML = `
            <td><img src="${product.image}" alt="${product.name}" class="product-thumbnail"></td>
            <td>${product.code}</td>
            <td>${product.name}</td>
            <td>${product.category}</td>
            <td>${product.stock}</td>
            <td class="price">${formatNumber(product.price)}</td>
            <td>
                <input type="number" class="form-control quantity-input" value="1" min="1" max="${product.stock}">
            </td>
            <td class="row-total">${formatNumber(product.price)}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-product">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;

        tbody.appendChild(tr);
        initializeRowEvents(tr);
    }

    updateInvoiceTotal();
    document.getElementById('productSearch').value = '';
    document.getElementById('productList').style.display = 'none';
}

function initializeRowEvents(row) {
    const quantityInput = row.querySelector('.quantity-input');
    const removeButton = row.querySelector('.remove-product');

    quantityInput.addEventListener('change', () => {
        updateRowTotal(row);
        updateInvoiceTotal();
    });

    removeButton.addEventListener('click', () => {
        row.remove();
        updateInvoiceTotal();
    });
}

function updateRowTotal(row) {
    const price = parseFloat(row.querySelector('.price').textContent.replace(/,/g, ''));
    const quantity = parseInt(row.querySelector('.quantity-input').value);
    const total = price * quantity;
    row.querySelector('.row-total').textContent = formatNumber(total);
}

function updateInvoiceTotal() {
    const rows = document.querySelectorAll('#selectedProducts tr');
    let subtotal = 0;

    rows.forEach(row => {
        subtotal += parseFloat(row.querySelector('.row-total').textContent.replace(/,/g, ''));
    });

    const discountPercent = parseFloat(document.getElementById('discount').value) || 0;
    const discountAmount = (subtotal * discountPercent) / 100;
    const finalAmount = subtotal - discountAmount;

    document.getElementById('totalAmount').textContent = formatNumber(subtotal);
    document.getElementById('discountAmount').textContent = formatNumber(discountAmount);
    document.getElementById('finalAmount').textContent = formatNumber(finalAmount);
}

function formatNumber(num) {
    return num.toLocaleString('fa-IR');
}
$(document).ready(function () {
    $('#customer_select').select2({
        theme: 'bootstrap4',
        dir: 'rtl',
        language: 'fa',
        placeholder: 'انتخاب مشتری...',
        minimumInputLength: 1,
        ajax: {
            url: '/api/persons/search',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return {
                    results: data.results
                };
            },
            cache: true
        },
        templateResult: function (person) {
            if (!person.id) return '';
            return $(`
                <div style="line-height:1.8">
                    <div><strong>${person.first_name ?? ''} ${person.last_name ?? ''}</strong></div>
                    <div>نوع: ${person.person_type ?? '-'}</div>
                    <div>کد حسابداری: ${person.accounting_code ?? '-'}</div>
                </div>
            `);
        },
        templateSelection: function (person) {
            if (!person.id) return 'انتخاب مشتری...';
            return `${person.first_name ?? ''} ${person.last_name ?? ''}`;
        },
        escapeMarkup: function (markup) { return markup; }
    });
});

$('#customer_select').select2({
    theme: 'bootstrap4',
    dir: 'rtl',
    language: 'fa',
    placeholder: 'انتخاب مشتری...',
    minimumInputLength: 2,
    ajax: {
        url: '/api/persons/search',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return { q: params.term };
        },
        processResults: function (data) {
            return {
                results: data.results
            };
        },
        cache: true
    },
    templateResult: function (person) {
        if (!person.id) return person.text;
        let details = [];
        if(person.mobile) details.push('موبایل: ' + person.mobile);
        if(person.email) details.push('ایمیل: ' + person.email);
        if(person.national_code) details.push('کدملی: ' + person.national_code);
        // فیلدهای دلخواه دیگر
        return $(`
            <div>
                <div><strong>${person.text}</strong></div>
                ${details.length ? `<ul style="margin-right:16px;">${details.map(d => `<li>${d}</li>`).join('')}</ul>` : ''}
            </div>
        `);
    },
    escapeMarkup: function (markup) { return markup; }
});
document.addEventListener('DOMContentLoaded', function() {
    // مقدار شماره فاکتور را هنگام لود از سرور بگیر
    fetch('/invoices/next-number')
        .then(res => res.json())
        .then(data => {
            let invoiceNumberInput = document.getElementById('invoiceNumber');
            invoiceNumberInput.value = data.number;
        });

    // مدیریت سوییچ شماره دستی
    let invoiceNumberInput = document.getElementById('invoiceNumber');
    let invoiceNumberSwitch = document.getElementById('invoiceNumberSwitch');

    invoiceNumberSwitch.addEventListener('change', function() {
        if (this.checked) {
            invoiceNumberInput.readOnly = false;
            invoiceNumberInput.value = '';
            invoiceNumberInput.focus();
        } else {
            invoiceNumberInput.readOnly = true;
            // مقدار شماره اتوماتیک را دوباره از سرور بگیر
            fetch('/invoices/next-number')
                .then(res => res.json())
                .then(data => {
                    invoiceNumberInput.value = data.number;
                });
        }
    });
});

$(document).on('click', '#productList tbody tr', function() {
    let id = $(this).data('id');
    let code = $(this).data('code');
    let name = $(this).data('name');
    let category = $(this).data('category');
    let stock = $(this).data('stock');
    let price = $(this).data('price');
    let image = $(this).data('image');

    // بررسی کن که این محصول قبلاً اضافه نشده باشد
    if($('#selectedProducts tr[data-id="' + id + '"]').length > 0) {
        Swal.fire('توجه', 'این محصول قبلاً اضافه شده است!', 'warning');
        return;
    }

    let row = `
        <tr data-id="${id}">
            <td><img src="${image}" alt="img" style="width:40px;height:40px"></td>
            <td>${code}</td>
            <td>${name}</td>
            <td>${category}</td>
            <td>${stock}</td>
            <td>
                <input type="number" name="products[${id}][price]" class="form-control input-sm product-price" value="${price}" min="0">
            </td>
            <td>
                <input type="number" name="products[${id}][qty]" class="form-control input-sm product-qty" value="1" min="1" max="${stock}">
            </td>
            <td class="product-total">${price}</td>
            <td><button type="button" class="btn btn-danger btn-sm remove-product"><i class="fas fa-trash"></i></button></td>
        </tr>
    `;
    $('#selectedProducts').append(row);

    // بعد از افزودن، لیست محصولات را پنهان کن
    $('#productList').hide();
    $('#productSearch').val('');
    updateInvoiceTotals();
});

// حذف محصول از جدول
$(document).on('click', '.remove-product', function() {
    $(this).closest('tr').remove();
    updateInvoiceTotals();
});

// وقتی قیمت یا تعداد تغییر کرد، مبلغ کل هر ردیف و جمع کل آپدیت شود
$(document).on('input', '.product-price, .product-qty', function() {
    let $row = $(this).closest('tr');
    let price = parseFloat($row.find('.product-price').val()) || 0;
    let qty = parseFloat($row.find('.product-qty').val()) || 1;
    $row.find('.product-total').text(price * qty);
    updateInvoiceTotals();
});





$('#productSearch').on('input', function() {
    let query = $(this).val().trim();
    if (query.length < 2) {
        $('#productList').hide();
        return;
    }
    $.getJSON('/api/products/search?q=' + encodeURIComponent(query), function(products) {
        if (!products.length) {
            $('#productList').html('<div class="alert alert-warning">محصولی یافت نشد.</div>').show();
            return;
        }
        let table = `
            <table class="table table-sm table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>کد محصول</th>
                        <th>نام محصول</th>
                        <th>دسته‌بندی</th>
                        <th>موجودی</th>
                        <th>قیمت فروش</th>
                        <th>انتخاب</th>
                    </tr>
                </thead>
                <tbody>
        `;
        products.forEach(function(item) {
            table += `
                <tr data-id="${item.id}" data-name="${item.name}" data-code="${item.code}"
                    data-category="${item.category_id}" data-stock="${item.stock || 0}"
                    data-sell_price="${item.sell_price || 0}" data-image="${item.image || ''}">
                    <td>${item.code || ''}</td>
                    <td>${item.name || ''}</td>
                    <td>${item.category_id || ''}</td>
                    <td>${item.stock || 0}</td>
                    <td>${item.sell_price ? item.sell_price.toLocaleString() : ''}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm select-product">انتخاب</button>
                    </td>
                </tr>
            `;
        });
        table += '</tbody></table>';
        $('#productList').html(table).show();
    });
});

// وقتی روی دکمه "انتخاب" کلیک شد، محصول به جدول محصولات انتخاب شده اضافه شود
$(document).on('click', '.select-product', function() {
    let $row = $(this).closest('tr');
    let id = $row.data('id');
    let name = $row.data('name');
    let code = $row.data('code');
    let category = $row.data('category');
    let stock = $row.data('stock');
    let price = $(this).data('sell_price') || 0;

    // چک نکن محصول تکراری اضافه نشود (اختیاری)
    if ($('#selectedProducts tr[data-id="' + id + '"]').length > 0) {
        Swal.fire('توجه', 'این محصول قبلاً اضافه شده است!', 'warning');
        return;
    }

    let selectedRow = `
        <tr data-id="${id}">
            <td>${code}</td>
            <td>${name}</td>
            <td>${category}</td>
            <td>${stock}</td>
            <td>
                <input type="number" name="products[${id}][price]" class="form-control input-sm product-price" value="${price}" min="0">
            </td>
            <td>
                <input type="number" name="products[${id}][qty]" class="form-control input-sm product-qty" value="1" min="1" max="${stock}">
            </td>
            <td class="product-total">${price}</td>
            <td><button type="button" class="btn btn-danger btn-sm remove-product"><i class="fas fa-trash"></i></button></td>
        </tr>
    `;
    $('#selectedProducts').append(selectedRow);

    // بعد از افزودن، لیست محصولات جستجو مخفی شود
    $('#productList').hide();
    $('#productSearch').val('');
    updateInvoiceTotals();
});

// تابع محاسبه جمع کل (اگر قبلاً نداری)
function updateInvoiceTotals() {
    let total = 0;
    $('#selectedProducts tr').each(function() {
        let price = parseFloat($(this).find('.product-price').val()) || 0;
        let qty = parseFloat($(this).find('.product-qty').val()) || 1;
        total += price * qty;
        $(this).find('.product-total').text(price * qty);
    });
    $('#totalAmount').text(total.toLocaleString());
}
