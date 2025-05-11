@extends('layouts.master')
@section('title', 'مشاهده محصول')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/products-show.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('js/products-show.js') }}"></script>
@endsection

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-info text-white d-flex align-items-center">
            <h4 class="mb-0 flex-grow-1">{{ $product->name }} ({{ $product->code }})</h4>
            <a href="{{ route('products.index') }}" class="btn btn-light">بازگشت به لیست</a>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- تصویر شاخص -->
                <div class="col-md-4 text-center mb-3">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" alt="تصویر محصول" class="img-fluid rounded shadow" style="max-height:200px;">
                    @else
                        <div class="alert alert-secondary">تصویر ندارد</div>
                    @endif
                    @if($product->video)
                        <video src="{{ asset('storage/'.$product->video) }}" controls class="mt-3" style="width:100%; max-width:280px; border-radius:10px;"></video>
                    @endif
                </div>
                <!-- اطلاعات کلی -->
                <div class="col-md-8">
                    <ul class="list-group mb-3">
                        <li class="list-group-item"><b>نام محصول:</b> {{ $product->name }}</li>
                        <li class="list-group-item"><b>کد محصول:</b> {{ $product->code }}</li>
                        <li class="list-group-item"><b>دسته‌بندی:</b> {{ $product->category?->name ?? '-' }}</li>
                        <li class="list-group-item"><b>برند:</b> {{ $product->brand?->name ?? '-' }}</li>
                        <li class="list-group-item"><b>قیمت خرید:</b> {{ number_format($product->buy_price) }}</li>
                        <li class="list-group-item"><b>قیمت فروش:</b> {{ number_format($product->sell_price) }}</li>
                        <li class="list-group-item"><b>تخفیف:</b> {{ $product->discount }}%</li>
                        <li class="list-group-item"><b>موجودی:</b> {{ $product->stock }}</li>
                        <li class="list-group-item"><b>حداقل هشدار موجودی:</b> {{ $product->min_stock }}</li>
                        <li class="list-group-item"><b>واحد:</b> {{ $product->unit }}</li>
                        <li class="list-group-item"><b>وزن:</b> {{ $product->weight }} گرم</li>
                        <li class="list-group-item"><b>بارکد:</b> {{ $product->barcode }}</li>
                        <li class="list-group-item"><b>بارکد فروشگاهی:</b> {{ $product->store_barcode }}</li>
                        <li class="list-group-item"><b>فعال:</b> {{ $product->is_active ? 'بله' : 'خیر' }}</li>
                    </ul>
                    <div>
                        <b>توضیحات کوتاه:</b>
                        <div class="border rounded p-2 mb-2">{{ $product->short_desc }}</div>
                        <b>توضیحات کامل:</b>
                        <div class="border rounded p-2">{!! nl2br(e($product->description)) !!}</div>
                    </div>
                </div>
            </div>
            <!-- نمایش گالری تصاویر -->
            @if($product->gallery && is_array($product->gallery))
                <div class="mt-4">
                    <h5>گالری تصاویر</h5>
                    <div class="row">
                        @foreach($product->gallery as $galleryImg)
                            <div class="col-md-2 mb-2">
                                <img src="{{ asset('storage/'.$galleryImg) }}" class="img-thumbnail" style="height:80px;object-fit:cover;">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            <!-- اگر ویژگی‌ها (attributes) داری -->
            @if($product->attributes && is_array($product->attributes))
                <div class="mt-4">
                    <h5>ویژگی‌های محصول (درختی)</h5>
                    <ul class="tree-list">
                        @foreach($product->attributes as $attr)
                            <li>
                                <b>{{ $attr['key'] ?? '' }}</b>
                                @if(isset($attr['value']))
                                    : <span>{{ $attr['value'] }}</span>
                                @endif
                                @if(isset($attr['children']))
                                    <ul>
                                        @foreach($attr['children'] as $child)
                                            <li>{{ $child }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
