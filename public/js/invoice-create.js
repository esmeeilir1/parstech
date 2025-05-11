$(document).ready(function () {
    // ------------------ مقداردهی و تنظیم تاریخ شمسی ------------------
    function getTodayPersian() {
        if (typeof persianDate !== 'undefined') {
            return new persianDate().format('YYYY/MM/DD');
        }
        let d = new Date();
        let y = d.getFullYear(), m = d.getMonth() + 1, day = d.getDate();
        return y + '/' + (m < 10 ? '0' + m : m) + '/' + (day < 10 ? '0' + day : day);
    }
    if(!$('#date').val()) $('#date').val(getTodayPersian());
    if(!$('#dueDate').val()) $('#dueDate').val(getTodayPersian());
    $('#date, #dueDate').persianDatepicker({
        format: 'YYYY/MM/DD',
        autoClose: true,
        persianDigit: true,
        initialValue: false
    });

    // ------------------ مقداردهی خودکار واحد پول به "ریال" ------------------
    let $currencySelect = $('#currency_id');
    if ($currencySelect.length) {
        let found = false;
        $currencySelect.find('option').each(function () {
            let t = $(this).text();
            if (t.includes('ریال') || t.includes('rial') || t.includes('Rial')) {
                $(this).prop('selected', true);
                found = true;
                return false;
            }
        });
        if (!found && $currencySelect.find('option').length === 2) {
            $currencySelect.find('option').eq(1).prop('selected', true);
        }
    }

    // ------------------ Select2 مشتری و فروشنده ------------------
    $('#customer_select').select2({
        theme: 'bootstrap4',
        dir: 'rtl',
        placeholder: 'انتخاب مشتری...',
        minimumInputLength: 1,
        ajax: {
            url: '/api/persons/search',
            dataType: 'json',
            delay: 250,
            data: function (params) { return { q: params.term }; },
            processResults: function (data) { return { results: data.results }; },
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
    $('#seller').select2({
        theme: 'bootstrap4',
        dir: 'rtl',
        placeholder: 'انتخاب فروشنده...',
        ajax: {
            url: '/api/sellers/search',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return { results: data.map(item => ({ id: item.id, text: item.name })) };
            }
        }
    });

    // ------------------ مدیریت شماره فاکتور ------------------
    const invoiceNumberInput = document.getElementById('invoiceNumber');
    const invoiceNumberSwitch = document.getElementById('invoiceNumberSwitch');
    if(invoiceNumberSwitch && invoiceNumberInput) {
        invoiceNumberSwitch.addEventListener('change', function() {
            invoiceNumberInput.readOnly = !this.checked;
            if (!this.checked) {
                fetch('/api/invoices/next-number')
                    .then(response => response.json())
                    .then(data => { invoiceNumberInput.value = data.number; });
            }
        });
    }

    // ------------------ تبدیل اعداد به فارسی با اعشار ------------------
    function toFaNum(num, digits = 2) {
        let faNums = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','.'];
        let str = Number(num).toFixed(digits).toString();
        return str.replace(/[0-9.]/g, w => faNums[w === '.' ? 10 : +w]);
    }

    // ------------------ گرفتن نام دسته‌بندی‌ها برای نمایش ------------------
    let categoryMap = {};
    $.getJSON('/api/categories/list', function(categories){
        categories.forEach(cat => categoryMap[cat.id] = cat.name);
    });

    // ------------------ جستجوی محصول ------------------
    const productSearch = document.getElementById('productSearch');
    const productList = document.getElementById('productList');
    function resizeProductList() {
        if(productSearch && productList) {
            const rect = productSearch.getBoundingClientRect();
            productList.style.position = "absolute";
            productList.style.zIndex = "9999";
            productList.style.width = rect.width + "px";
            productList.style.right = (window.innerWidth - rect.right) + "px";
        }
    }
    if(productSearch && productList) {
        productSearch.addEventListener('focus', resizeProductList);
        window.addEventListener('resize', resizeProductList);
    }

    $('#productSearch').on('input', function () {
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
            const maxStock = Math.max(...products.map(p => p.stock || 0), 1);
            let table = `
                <table class="table table-sm table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th>تصویر</th>
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
                let stock = item.stock || 0;
                let color = "#e0ffe0";
                if (stock < 1) color = "#ffdddd";
                else if (stock < maxStock * 0.2) color = "#ffd9b3";
                else if (stock < maxStock * 0.5) color = "#fff2cc";
                else if (stock < maxStock * 0.8) color = "#e0ffe0";
                let disabled = stock < 1 ? "disabled" : "";
                let price = (typeof item.sell_price === "number") ? item.sell_price : parseFloat(item.sell_price) || 0;
                // گرفتن نام دسته‌بندی
                let categoryName = item.category?.name || item.category_name || categoryMap[item.category_id] || item.category_id || '-';
                table += `
                    <tr style="background:${color};cursor:pointer;" class="product-row"
                        data-id="${item.id}" data-name="${item.name}" data-code="${item.code}"
                        data-category="${categoryName}" data-stock="${stock}"
                        data-sell_price="${price}" data-image="${item.image || ''}">
                        <td><img src="${item.image || ''}" style="width:32px;height:32px"/></td>
                        <td>${item.code || ''}</td>
                        <td>${item.name || ''}</td>
                        <td>${categoryName}</td>
                        <td>${toFaNum(stock, 0)}</td>
                        <td>${toFaNum(price, 2)}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm select-product" ${disabled}>انتخاب</button>
                        </td>
                    </tr>
                `;
            });
            table += '</tbody></table>';
            $('#productList').html(table).show();
            resizeProductList();
        });
    });

    // اضافه کردن محصول به فاکتور (هم با کلیک روی ردیف، هم دکمه)
    function addProductToTable($row) {
        let id = $row.data('id');
        let name = $row.data('name');
        let code = $row.data('code');
        let category = $row.data('category');
        let stock = $row.data('stock');
        let price = $row.data('sell_price') || 0;
        let image = $row.data('image') || '';
        if ($('#selectedProducts tr[data-id="' + id + '"]').length > 0) {
            Swal.fire('توجه', 'این محصول قبلاً اضافه شده است!', 'warning');
            return;
        }
        let row = `
            <tr data-id="${id}">
                <td><img src="${image}" alt="img" style="width:40px;height:40px"></td>
                <td>${code}</td>
                <td>${name}</td>
                <td>${category}</td>
                <td>${toFaNum(stock, 0)}</td>
                <td>
                    <input type="number" name="products[${id}][price]" class="form-control input-sm product-price" value="${price}" min="0" readonly>
                </td>
                <td>
                    <input type="number" name="products[${id}][qty]" class="form-control input-sm product-qty" value="1" min="1" max="${stock}">
                </td>
                <td class="product-total">${toFaNum(price, 2)}</td>
                <td><button type="button" class="btn btn-danger btn-sm remove-product"><i class="fas fa-trash"></i></button></td>
            </tr>
        `;
        $('#selectedProducts').append(row);
        $('#productList').hide();
        $('#productSearch').val('');
        updateInvoiceTotals();
    }
    $(document).on('click', '.product-row', function (e) {
        if ($(e.target).hasClass('select-product')) return;
        addProductToTable($(this));
    });
    $(document).on('click', '.select-product', function (e) {
        e.stopPropagation();
        addProductToTable($(this).closest('tr'));
    });

    // کنترل تعداد و تبدیل اعداد به فارسی اعشاری
    $(document).on('input', '.product-qty', function() {
        let $input = $(this);
        let $row = $input.closest('tr');
        let max = parseInt($input.attr('max'), 10);
        let val = parseInt($input.val(), 10) || 1;
        if (val > max) {
            $input.val(max);
            let name = $row.find('td').eq(2).text();
            Swal.fire('توجه', `موجودی محصول "${name}" فقط ${toFaNum(max, 0)} عدد است، نمی‌توانید بیش از این به فاکتور اضافه کنید.`, 'error');
            val = max;
        }
        let price = parseFloat($row.find('.product-price').val()) || 0;
        $row.find('.product-total').text(toFaNum(price * val, 2));
        updateInvoiceTotals();
    });

    // حذف محصول از جدول
    $(document).on('click', '.remove-product', function() {
        $(this).closest('tr').remove();
        updateInvoiceTotals();
    });

    // تغییر قیمت و تعداد
    $(document).on('input', '.product-price', function() {
        let $row = $(this).closest('tr');
        let price = parseFloat($(this).val()) || 0;
        let qty = parseFloat($row.find('.product-qty').val()) || 1;
        $row.find('.product-total').text(toFaNum(price * qty, 2));
        updateInvoiceTotals();
    });

    // ------------------ رویدادهای تخفیف و مالیات ------------------
    $('#discount_percent, #discount_amount, #tax_percent').on('input', updateInvoiceTotals);
    $('#discount_percent').on('input', function () {
        $('#discount_amount').val('');
    });
    $('#discount_amount').on('input', function () {
        $('#discount_percent').val('');
    });

    // ------------------ محاسبه جمع کل، تخفیف، مالیات و مبلغ نهایی ------------------
    function updateInvoiceTotals() {
        let total = 0;
        $('#selectedProducts tr').each(function() {
            let price = parseFloat($(this).find('.product-price').val()) || 0;
            let qty = parseFloat($(this).find('.product-qty').val()) || 1;
            total += price * qty;
            $(this).find('.product-total').text(toFaNum(price * qty, 2));
        });
        $('#totalAmount').text(toFaNum(total, 2));

        // محاسبه تخفیف (درصد یا مبلغ)
        let discountPercent = parseFloat($('#discount_percent').val()) || 0;
        let discountAmount = parseFloat($('#discount_amount').val()) || 0;
        let discountValue = 0;
        if (discountAmount > 0) {
            discountValue = discountAmount;
        } else if (discountPercent > 0) {
            discountValue = (total * discountPercent) / 100;
        }
        $('#discountAmount').text(toFaNum(discountValue, 2));

        // جمع پس از تخفیف
        let afterDiscount = total - discountValue;

        // محاسبه مالیات (درصد)
        let taxPercent = parseFloat($('#tax_percent').val()) || 0;
        let taxValue = (afterDiscount * taxPercent) / 100;
        $('#taxAmount').text(toFaNum(taxValue, 2));

        // مبلغ نهایی
        let finalAmount = afterDiscount + taxValue;
        $('#finalAmount').text(toFaNum(finalAmount, 2));
    }
});
