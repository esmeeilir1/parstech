@extends('layouts.app')

@section('title', 'لیست فروشندگان')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h3 class="mb-4">لیست فروشندگان</h3>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <a href="{{ route('sellers.create') }}" class="btn btn-primary mb-3">افزودن فروشنده جدید</a>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>تصویر</th>
                            <th>کد فروشنده</th>
                            <th>نام</th>
                            <th>نام خانوادگی</th>
                            <th>موبایل</th>
                            <th>شرکت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sellers as $seller)
                        <tr>
                            <td>
                                <img src="{{ $seller->image ? asset('storage/' . $seller->image) : asset('img/user-default.png') }}"
                                     class="rounded-circle" style="width:48px;height:48px;">
                            </td>
                            <td>{{ $seller->seller_code }}</td>
                            <td>{{ $seller->first_name }}</td>
                            <td>{{ $seller->last_name }}</td>
                            <td>{{ $seller->mobile }}</td>
                            <td>{{ $seller->company_name }}</td>
                            <td>
                                <a href="{{ route('sellers.show', $seller) }}" class="btn btn-sm btn-info">نمایش</a>
                                <a href="{{ route('sellers.edit', $seller) }}" class="btn btn-sm btn-warning">ویرایش</a>
                                <form action="{{ route('sellers.destroy', $seller) }}" method="POST" style="display:inline;" onsubmit="return confirm('آیا حذف شود؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">حذف</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">هیچ فروشنده‌ای ثبت نشده است.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div>
                {{ $sellers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
