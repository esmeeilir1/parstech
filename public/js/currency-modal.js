const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

document.addEventListener('DOMContentLoaded', function () {
    // باز کردن مدال با کلیک منو
    document.getElementById('openCurrencyModal').addEventListener('click', function (e) {
        e.preventDefault();
        loadCurrencies();
        new bootstrap.Modal(document.getElementById('currencyModal')).show();
    });

    // افزودن یا ویرایش ارز
    document.getElementById('addCurrencyBtn').onclick = function () {
        const id = document.getElementById('editCurrencyId').value;
        const title = document.getElementById('curTitle').value.trim();
        const symbol = document.getElementById('curSymbol').value.trim();
        const code = document.getElementById('curCode').value.trim();

        if (title === '') return alert('نام ارز الزامی است');

        const data = { title, symbol, code };
        if (id) data.id = id;

        fetch('/currencies', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(() => {
            clearForm();
            loadCurrencies();
        });
    };

    // لود لیست ارزها
function loadCurrencies() {
    fetch('/currencies', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.json())
        .then(data => {
            const tbody = document.querySelector('#currenciesTable tbody');
            tbody.innerHTML = '';
            data.forEach(cur => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${cur.title || ''}</td>
                    <td>${cur.symbol || ''}</td>
                    <td>${cur.code || ''}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" onclick="editCurrency(${cur.id},'${cur.title}','${cur.symbol}','${cur.code}')">ویرایش</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteCurrency(${cur.id})">حذف</button>
                    </td>`;
                tbody.appendChild(row);
            });
        });
}

    window.editCurrency = function(id, title, symbol, code) {
        document.getElementById('editCurrencyId').value = id;
        document.getElementById('curTitle').value = title;
        document.getElementById('curSymbol').value = symbol;
        document.getElementById('curCode').value = code;
        document.getElementById('addCurrencyBtn').textContent = 'ویرایش';
    };

    window.deleteCurrency = function(id) {
        if(!confirm('حذف شود؟')) return;
        fetch(`/currencies/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(() => loadCurrencies());
    };

    function clearForm() {
        document.getElementById('editCurrencyId').value = '';
        document.getElementById('curTitle').value = '';
        document.getElementById('curSymbol').value = '';
        document.getElementById('curCode').value = '';
        document.getElementById('addCurrencyBtn').textContent = 'افزودن';
    }
});
