<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد | حسابیر</title>
    <link rel="stylesheet" href="../../fonts/fonts.css">
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-xs8dF..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('css/sidebar-custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" rel="stylesheet">


    <!-- در head -->



    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        tailwind.config = {
            theme: { fontFamily: { 'sans': ['AnjomanMax', 'Tahoma', 'sans-serif'] }, },
            rtl: true,
        }
    </script>
    <style>
        body { background: #f9fafb; }

    </style>
    @yield('head')
    @stack('styles')
    <!-- Modal مدیریت واحد پول -->
<div class="modal fade" id="currencyModal" tabindex="-1" aria-labelledby="currencyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="currencyForm" autocomplete="off">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">مدیریت واحدهای پول</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="بستن">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- لیست ارزها -->
          <table class="table table-bordered mb-3" id="currenciesTable">
            <thead>
              <tr>
                <th>نام</th>
                <th>نماد</th>
                <th>کد</th>
                <th>عملیات</th>
              </tr>
            </thead>
            <tbody>
              <!-- سطرها با جاوااسکریپت لود می‌شود -->
            </tbody>
          </table>
          <hr>
          <!-- فرم افزودن/ویرایش ارز -->
          <div class="row">
            <div class="col-md-4">
              <input type="text" class="form-control mb-2" id="curTitle" placeholder="نام ارز (مثلاً دلار)">
            </div>
            <div class="col-md-3">
              <input type="text" class="form-control mb-2" id="curSymbol" placeholder="نماد (مثلاً $)">
            </div>
            <div class="col-md-3">
              <input type="text" class="form-control mb-2" id="curCode" placeholder="کد (مثلاً USD)">
            </div>
            <div class="col-md-2">
              <button type="button" class="btn btn-success w-100 mb-2" id="addCurrencyBtn">افزودن</button>
            </div>
          </div>
          <input type="hidden" id="editCurrencyId">
        </div>
      </div>
    </form>
  </div>
</div>
</head>
<body>


    @include('layouts.sidebar')
    <div class="main-content" id="main-content">
        @yield('content')
    </div>

<script>
window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
</script>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/currency-modal.js') }}"></script>
<script src="{{ asset('js/sidebar-custom.js') }}"></script>


</script>
@yield('scripts')
@stack('scripts')
</body>
</html>
