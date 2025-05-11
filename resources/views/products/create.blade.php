@extends('layouts.master')
@section('title', 'افزودن محصول جدید')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/products-create.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar-custom.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@6.0.0-beta.2/dist/dropzone.css" />
@endsection

@section('content')
<div class="container-fluid product-create-page">
    <div class="row">
        {{-- سایدبار اصلی پروژه --}}
        @include('layouts.sidebar')

        <div class="col-xl-10 col-lg-9 col-md-8 main-content">
            <div class="card shadow-lg mt-4 mb-5">
                <div class="card-header product-header">
                    <h1 class="product-title">افزودن محصول جدید</h1>
                </div>
                <div class="card-body">
                    <form id="product-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- اطلاعات پایه -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">نام محصول <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">کد کالا</label>
                                <div class="input-group">
                                    <input type="text" name="code" id="product-code" class="form-control" value="{{ old('code', $default_code) }}" readonly>
                                    <span class="input-group-text">
                                        <div class="form-check form-switch m-0">
                                            <input class="form-check-input" type="checkbox" id="code-edit-switch">
                                        </div>
                                    </span>
                                </div>
                                <small class="text-muted">برای تعریف محصول سفارشی، سوییچ را غیرفعال کن تا امکان ویرایش کد فراهم شود.</small>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">دسته‌بندی کالا <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select form-select-lg" required>
                                    <option value="">انتخاب کنید...</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" @if(old('category_id')==$cat->id) selected @endif>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">برند</label>
                                <div class="input-group">
                                    <select name="brand_id" class="form-select">
                                        <option value="">بدون برند</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" @if(old('brand_id')==$brand->id) selected @endif>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    <a href="{{ route('brands.create') }}" target="_blank" class="btn btn-outline-primary">برند جدید</a>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">تصویر شاخص محصول</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label class="form-label">گالری تصاویر</label>
                                <div id="gallery-dropzone" class="dropzone"></div>
                                <input type="hidden" name="gallery[]" id="gallery-input">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">ویدیوی معرفی محصول</label>
                                <input type="file" name="video" class="form-control" accept="video/*">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label class="form-label">موجودی اولیه</label>
                                <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">حداقل موجودی هشدار</label>
                                <input type="number" name="min_stock" class="form-control" value="{{ old('min_stock', 0) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">واحد اندازه‌گیری</label>
                                <select name="unit" id="selected-unit" class="form-select">
                                    <option value="">انتخاب کنید...</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->title }}" @if(old('unit')==$unit->title) selected @endif>{{ $unit->title }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-outline-info mt-2 w-100" data-bs-toggle="modal" data-bs-target="#unitModal">
                                    مدیریت واحدها
                                </button>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">وزن (گرم)</label>
                                <input type="number" name="weight" class="form-control" value="{{ old('weight') }}">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">قیمت خرید</label>
                                <input type="number" name="buy_price" class="form-control" value="{{ old('buy_price') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">قیمت فروش</label>
                                <input type="number" name="sell_price" class="form-control" value="{{ old('sell_price') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">تخفیف (%)</label>
                                <input type="number" name="discount" class="form-control" value="{{ old('discount') }}">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">توضیحات کوتاه</label>
                                <textarea name="short_desc" class="form-control" rows="2">{{ old('short_desc') }}</textarea>
                            </div>
                            <div class="col-md-12 mt-3">
                                <label class="form-label">توضیحات کامل</label>
                                <textarea name="description" class="form-control" rows="6">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">بارکد محصول</label>
                                <input type="text" name="barcode" class="form-control" value="{{ old('barcode') }}">
                                <button type="button" class="btn btn-outline-primary mt-2" onclick="generateBarcode('barcode')">ساخت بارکد</button>
                                <span class="barcode-status"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">بارکد فروشگاهی</label>
                                <input type="text" name="store_barcode" class="form-control" value="{{ old('store_barcode') }}">
                                <button type="button" class="btn btn-outline-secondary mt-2" onclick="generateBarcode('store_barcode')">ساخت بارکد فروشگاه</button>
                                <span class="barcode-status"></span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                                    <label class="form-check-label" for="is_active">فعال باشد</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">ویژگی‌های محصول</label>
                                <div id="attributes-area"></div>
                                <button type="button" class="btn btn-outline-success mt-2" id="add-attribute">افزودن ویژگی</button>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success btn-lg px-4">ثبت محصول</button>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary btn-lg px-4">انصراف</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: مدیریت واحد اندازه‌گیری -->
<div class="modal fade" id="unitModal" tabindex="-1" aria-labelledby="unitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">مدیریت واحدهای اندازه‌گیری</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="units-list">
                    @foreach($units as $unit)
                        <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $unit->id }}">
                            <span class="unit-title">{{ $unit->title }}</span>
                            <div>
                                <button type="button" class="btn btn-sm btn-primary edit-unit-btn me-1">ویرایش</button>
                                <button type="button" class="btn btn-sm btn-danger delete-unit-btn">حذف</button>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <hr>
                <form id="add-unit-form" class="d-flex gap-2 mt-2">
                    <input type="text" class="form-control" id="unit-title" placeholder="واحد جدید">
                    <button type="submit" class="btn btn-success">افزودن واحد</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/dropzone@6.0.0-beta.2/dist/dropzone-min.js"></script>
    <script src="{{ asset('js/products-create.js') }}"></script>
@endsection
