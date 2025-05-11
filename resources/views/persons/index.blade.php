@extends('layouts.app')

@section('title', 'لیست اشخاص')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h3 class="mb-4">لیست اشخاص</h3>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <a href="{{ route('persons.create') }}" class="btn btn-primary mb-3">افزودن شخص جدید</a>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>کد حسابداری</th>
                            <th>نام</th>
                            <th>نام خانوادگی</th>
                            <th>نوع</th>
                            <th>شرکت</th>
                            <th>موبایل</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($persons as $person)
                            <tr>
                                <td>{{ $person->accounting_code }}</td>
                                <td>{{ $person->first_name }}</td>
                                <td>{{ $person->last_name }}</td>
                                <td>{{ $person->type }}</td>
                                <td>{{ $person->company_name }}</td>
                                <td>{{ $person->mobile }}</td>
                                <td>
                                    <a href="{{ route('persons.show', $person) }}" class="btn btn-sm btn-info">نمایش</a>
                                    <a href="{{ route('persons.edit', $person) }}" class="btn btn-sm btn-warning">ویرایش</a>
                                    <form action="{{ route('persons.destroy', $person) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('آیا از حذف این شخص مطمئن هستید؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">هیچ شخصی ثبت نشده است.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{ $persons->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
