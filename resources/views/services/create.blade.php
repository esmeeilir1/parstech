@extends('layouts.app')
@section('title', 'افزودن خدمات')

@section('head')
<link rel="stylesheet" href="{{ asset('css/service-create.css') }}">
@endsection

@section('content')
<section class="content pt-4">
    <div class="container-fluid">
        <div class="card card-outline card-primary shadow">
            <div class="card-header service-colored" id="service-header">
                <h5 class="mb-0">افزودن خدمات</h5>
            </div>
            <form id="service-form" action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-5">
                            <label for="title">عنوان خدمات <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" required autofocus>
                        </div>
                        <div class="col-md-4">
                            <label for="service_code">کد خدمات</label>
                            <div class="input-group">
                                <input type="text" name="service_code" id="service_code" class="form-control" readonly>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <input type="checkbox" id="custom_code_switch" title="شخصی‌سازی کد">
                                        <span class="ml-2">کد دستی</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="service_category_id">گروه خدمات</label>
                            <select name="service_category_id" id="service_category_id" class="form-control">
                                <option value="">انتخاب کنید</option>
                                @foreach($serviceCategories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>  
                    <div class="row mb-3 align-items-end">
                       <div class="col-md-3">
                            <label for="unit">واحد</label>
                            <div class="input-group">
                                <select name="unit" id="unit" class="form-control">
                                    @foreach($units as $unit)
                                        <option value="{{ $unit }}">{{ $unit }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-primary" id="add-unit-btn">افزودن واحد</button>
                                </div>
                            </div>
                            <ul id="unit-list" class="list-group mt-2">
                                @foreach($units as $unit)
                                    <li class="list-group-item d-flex justify-content-between align-items-center p-1">
                                        <span class="unit-name">{{ $unit }}</span>
                                        <span>
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-unit-btn">حذف</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary edit-unit-btn">ویرایش</button>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <label for="price">قیمت پایه (ریال)</label>
                            <input type="number" name="price" id="price" class="form-control" min="0">
                        </div>
                        <div class="col-md-3">
                            <label for="tax">مالیات (%)</label>
                            <input type="number" name="tax" id="tax" class="form-control" min="0" max="100">
                        </div>
                        <div class="col-md-3">
                            <label for="execution_cost">هزینه اجرا (ریال)</label>
                            <input type="number" name="execution_cost" id="execution_cost" class="form-control" min="0">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="short_description">شرح کوتاه</label>
                            <input type="text" name="short_description" id="short_description" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="image">تصویر خدمات</label>
                            <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
                            <img id="image_preview" src="#" style="display:none;max-width:150px;margin-top:10px;">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="description">توضیحات تکمیلی</label>
                            <textarea name="description" id="description" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-2">
                            <label for="is_active" class="mr-2">فعال باشد؟</label>
                            <label class="switch">
                                <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                                <span class="switch-slider"></span>
                            </label>
                        </div>
                        <div class="col-md-2">
                            <label for="is_vat_included" class="mr-2">شامل مالیات؟</label>
                            <input type="checkbox" name="is_vat_included" id="is_vat_included" value="1" checked>
                        </div>
                        <div class="col-md-2">
                            <label for="is_discountable" class="mr-2">قابل تخفیف؟</label>
                            <input type="checkbox" name="is_discountable" id="is_discountable" value="1" checked>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-left">
                    <button type="submit" class="btn btn-success">ثبت خدمات</button>
                    <a href="{{ route('services.index') }}" class="btn btn-secondary">انصراف</a>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Modal افزودن/ویرایش واحد -->
<div class="modal fade" id="addUnitModal" tabindex="-1" aria-labelledby="addUnitModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form id="add-unit-form" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUnitModalLabel">افزودن/ویرایش واحد</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="بستن">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" id="new-unit-input" placeholder="نام واحد" required>
        <input type="hidden" id="edit-unit-index">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
        <button type="submit" class="btn btn-primary">ذخیره</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/service-create.js') }}"></script>
@endsection
