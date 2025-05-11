@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6">
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl p-6 shadow">
            <h3 class="font-bold text-lg text-blue-700 mb-2">درآمد ماهانه</h3>
            <div id="chart-income"></div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow">
            <h3 class="font-bold text-lg text-green-700 mb-2">هزینه ماهانه</h3>
            <div id="chart-expense"></div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow">
            <h3 class="font-bold text-lg text-cyan-700 mb-2">مانده حساب‌ها</h3>
            <div id="chart-balance"></div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow">
            <h3 class="font-bold text-lg text-teal-700 mb-2">درآمد به تفکیک بخش‌ها</h3>
            <div id="chart-income-pie"></div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow">
            <h3 class="font-bold text-lg text-orange-700 mb-2">تعداد فاکتورهای فروش</h3>
            <div id="chart-invoices"></div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow">
            <h3 class="font-bold text-lg text-purple-700 mb-2">گردش پول</h3>
            <div id="chart-cashflow"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // درآمد ماهانه (bar)
    new ApexCharts(document.querySelector("#chart-income"), {
        chart: { type: 'bar', height: 180, fontFamily: 'AnjomanMax, Tahoma, sans-serif' },
        series: [{ name: 'درآمد', data: [120, 180, 140, 160, 210, 220] }],
        xaxis: { categories: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور'] },
        colors: ['#2563eb'],
        dataLabels: { enabled: false }
    }).render();

    // هزینه ماهانه (area)
    new ApexCharts(document.querySelector("#chart-expense"), {
        chart: { type: 'area', height: 180, fontFamily: 'AnjomanMax, Tahoma, sans-serif' },
        series: [{ name: 'هزینه', data: [90, 110, 100, 120, 115, 130] }],
        xaxis: { categories: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور'] },
        colors: ['#16a34a'],
        dataLabels: { enabled: false }
    }).render();

    // مانده حساب‌ها (radialBar)
    new ApexCharts(document.querySelector("#chart-balance"), {
        chart: { type: 'radialBar', height: 180, fontFamily: 'AnjomanMax, Tahoma, sans-serif' },
        series: [78],
        labels: ['٪ تحقق بودجه'],
        colors: ['#0891b2']
    }).render();

    // درآمد به تفکیک بخش‌ها (pie)
    new ApexCharts(document.querySelector("#chart-income-pie"), {
        chart: { type: 'pie', height: 180, fontFamily: 'AnjomanMax, Tahoma, sans-serif' },
        series: [44, 25, 21, 10],
        labels: ['فروش', 'خدمات', 'سایر', 'سود سهام'],
        colors: ['#0369a1','#f59e42','#eab308','#6366f1']
    }).render();

    // تعداد فاکتورهای فروش (line)
    new ApexCharts(document.querySelector("#chart-invoices"), {
        chart: { type: 'line', height: 180, fontFamily: 'AnjomanMax, Tahoma, sans-serif' },
        series: [{ name: 'فاکتور', data: [14, 18, 17, 20, 19, 25] }],
        xaxis: { categories: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور'] },
        colors: ['#f59e42'],
        dataLabels: { enabled: false }
    }).render();

    // گردش پول (donut)
    new ApexCharts(document.querySelector("#chart-cashflow"), {
        chart: { type: 'donut', height: 180, fontFamily: 'AnjomanMax, Tahoma, sans-serif' },
        series: [300, 150, 120],
        labels: ['واریز', 'برداشت', 'انتقال'],
        colors: ['#a21caf','#2563eb','#f59e42']
    }).render();
});
</script>
@endsection
