@extends('layouts.app')

@section('title', 'لیست دسته‌بندی‌ها')

@section('content')
<link rel="stylesheet" href="{{ asset('css/category-invoice-table.css') }}">

<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-lg rounded-lg overflow-x-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-700">لیست دسته‌بندی‌ها</h2>
            <a href="{{ route('categories.create') }}" class="btn btn-success text-white px-4 py-2 rounded-md">افزودن دسته‌بندی</a>
        </div>
        @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="category-invoice-table w-full min-w-[700px]">
                <thead>
                    <tr>
                        <th>نام</th>
                        <th>کد</th>
                        <th>نوع</th>
                        <th>زیر دسته‌ها</th>
                        <th class="text-center">عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $cat)
                        <tr class="main-row">
                            <td>
                                <div class="font-semibold text-slate-700">{{ $cat->name }}</div>
                            </td>
                            <td>
                                <span class="invoice-badge invoice-badge-blue">{{ $cat->code }}</span>
                            </td>
                            <td>
                                <span class="invoice-badge invoice-badge-type-{{ $cat->category_type }}">
                                    {{ categoryTypeFa($cat->category_type) }}
                                </span>
                            </td>
                            <td>
                                @if($cat->children->count() > 0)
                                    <ul class="subcat-list">
                                        @foreach($cat->children as $sub)
                                            <li>
                                                <span class="font-semibold text-indigo-700">{{ $sub->name }}</span>
                                                <span class="invoice-badge invoice-badge-blue">{{ $sub->code }}</span>
                                                <span class="invoice-badge invoice-badge-type-{{ $sub->category_type }}">
                                                    {{ categoryTypeFa($sub->category_type) }}
                                                </span>
                                                <a href="{{ route('categories.edit', $sub->id) }}" class="action-btn edit" title="ویرایش"><i class="fa fa-edit"></i></a>
                                                <form method="POST" action="{{ route('categories.destroy', $sub->id) }}" class="d-inline" onsubmit="return confirm('حذف این زیر دسته؟');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="action-btn delete" type="submit" title="حذف"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('categories.edit', $cat->id) }}" class="action-btn edit" title="ویرایش"><i class="fa fa-edit"></i></a>
                                <form method="POST" action="{{ route('categories.destroy', $cat->id) }}" class="d-inline" onsubmit="return confirm('حذف این دسته؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="action-btn delete" type="submit" title="حذف"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($categories->count() == 0)
                        <tr>
                            <td colspan="5" class="text-center text-slate-400 py-4">دسته‌ای وجود ندارد.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
