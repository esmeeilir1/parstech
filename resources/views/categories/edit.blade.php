@extends('layouts.app')

@section('title', 'ویرایش دسته‌بندی')

@section('content')
<link rel="stylesheet" href="{{ asset('css/category-invoice-table.css') }}">
<style>
.edit-category-card {
    max-width: 520px;
    margin: 40px auto 0 auto;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 24px #64748b11;
    padding: 32px 28px 24px 28px;
}
.edit-category-card h2 {
    font-size: 1.35rem;
    font-weight: bold;
    color: #334155;
    margin-bottom: 22px;
    letter-spacing: -.5px;
}
.form-label {
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
}
.form-control, select.form-control {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    color: #222;
    font-size: 1rem;
    margin-bottom: 12px;
    transition: border-color .16s;
}
.form-control:focus, select.form-control:focus {
    border-color: #1a73e8;
    background: #fff;
}
.edit-actions {
    margin-top: 20px;
    display: flex;
    gap: 12px;
    justify-content: flex-end;
}
.btn-success {
    background: #1a73e8 !important;
    color: #fff !important;
    border: none;
    border-radius: 8px;
    padding: 8px 20px;
    font-weight: bold;
    font-size: 1.06rem;
    transition: background 0.18s;
}
.btn-success:hover { background: #1565c0 !important; }
.btn-secondary {
    background: #f1f5f9 !important;
    color: #334155 !important;
    border-radius: 8px;
    padding: 8px 20px;
    font-weight: bold;
    font-size: 1.06rem;
    border: none;
    transition: background 0.15s;
}
.btn-secondary:hover { background: #e3e8ef !important; }
.alert { border-radius: 8px; }
</style>

<div class="edit-category-card">
    <h2>ویرایش دسته‌بندی</h2>

    @if(session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-2">
            <label class="form-label">نام دسته‌بندی</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
        </div>
        <div class="mb-2">
            <label class="form-label">کد دسته‌بندی</label>
            <input type="text" name="code" class="form-control" value="{{ old('code', $category->code) }}" required>
        </div>
        <div class="mb-2">
            <label class="form-label">توضیحات</label>
            <textarea name="description" class="form-control" rows="2">{{ old('description', $category->description) }}</textarea>
        </div>
        <div class="mb-2">
            <label class="form-label">زیر دسته</label>
            <select name="parent_id" class="form-control">
                <option value="">بدون زیر دسته</option>
                @foreach($categories as $cat)
                    @if($cat->id != $category->id)
                        <option value="{{ $cat->id }}" @if(old('parent_id', $category->parent_id) == $cat->id) selected @endif>
                            {{ $cat->name }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="edit-actions">
            <button type="submit" class="btn btn-success">ذخیره تغییرات</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">بازگشت</a>
        </div>
    </form>
</div>
@endsection
