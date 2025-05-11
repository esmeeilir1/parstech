@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">مدیریت واحدهای پول</h3>
    <button class="btn btn-success mb-3" id="addCurrencyBtn">افزودن واحد پول جدید</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>نام واحد</th>
                <th>کد</th>
                <th>نماد</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody id="currenciesTableBody">
            @foreach($currencies as $currency)
                <tr data-id="{{ $currency->id }}">
                    <td>{{ $currency->title }}</td>
                    <td>{{ $currency->code }}</td>
                    <td>{{ $currency->symbol }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm editCurrencyBtn">ویرایش</button>
                        <button class="btn btn-danger btn-sm deleteCurrencyBtn">حذف</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="currencyModal" tabindex="-1" aria-labelledby="currencyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="currencyForm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="currencyModalLabel">افزودن واحد پول</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="currencyTitle" class="form-label">نام واحد پول</label>
                    <input type="text" class="form-control" id="currencyTitle" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="currencyCode" class="form-label">کد</label>
                    <input type="text" class="form-control" id="currencyCode" name="code">
                </div>
                <div class="mb-3">
                    <label for="currencySymbol" class="form-label">نماد</label>
                    <input type="text" class="form-control" id="currencySymbol" name="symbol">
                </div>
                <input type="hidden" id="currencyId" name="id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                <button type="submit" class="btn btn-primary">ذخیره</button>
            </div>
        </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = new bootstrap.Modal(document.getElementById('currencyModal'));
    const form = document.getElementById('currencyForm');
    let editingId = null;

    document.getElementById('addCurrencyBtn').addEventListener('click', function() {
        form.reset();
        editingId = null;
        document.getElementById('currencyModalLabel').textContent = 'افزودن واحد پول';
        modal.show();
    });

    document.querySelectorAll('.editCurrencyBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            editingId = row.getAttribute('data-id');
            document.getElementById('currencyModalLabel').textContent = 'ویرایش واحد پول';
            document.getElementById('currencyTitle').value = row.children[0].textContent.trim();
            document.getElementById('currencyCode').value = row.children[1].textContent.trim();
            document.getElementById('currencySymbol').value = row.children[2].textContent.trim();
            document.getElementById('currencyId').value = editingId;
            modal.show();
        });
    });

    document.querySelectorAll('.deleteCurrencyBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const id = row.getAttribute('data-id');
            if(confirm('آیا از حذف این واحد پول مطمئن هستید؟')) {
                axios.delete(`/currencies/${id}`)
                    .then(() => location.reload())
                    .catch(() => alert('خطا در حذف!'));
            }
        });
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const data = new FormData(form);
        const id = data.get('id');
        const url = id ? `/currencies/${id}` : '/currencies';
        const method = id ? 'post' : 'post';
        const config = { headers: {'X-Requested-With': 'XMLHttpRequest'} };

        axios[method](url, data, config)
            .then(() => location.reload())
            .catch(() => alert('خطا در ذخیره!'));
    });
});
</script>
@endpush
