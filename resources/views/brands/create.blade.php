@extends('layouts.master')
@section('title', 'افزودن برند جدید')
@section('content')
<div class="container py-4">
    <h2>افزودن برند جدید</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data" class="card p-4">
        @csrf
        <div class="mb-3">
            <label class="form-label">
                نام برند <span class="text-danger">*</span>
            </label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">
                تصویر برند
            </label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <button class="btn btn-success">
            ثبت برند
        </button>
    </form>
</div>
@endsection
