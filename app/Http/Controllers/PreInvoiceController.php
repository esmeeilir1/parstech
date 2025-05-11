<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreInvoiceController extends Controller
{
    public function index()
    {
        return view('pre-invoices.index');
    }

    public function create()
    {
        return view('pre-invoices.create');
    }

    public function store(Request $request)
    {
        // اعتبارسنجی و ذخیره پیش فاکتور
    }

    public function show($id)
    {
        return view('pre-invoices.show');
    }

    public function edit($id)
    {
        return view('pre-invoices.edit');
    }

    public function update(Request $request, $id)
    {
        // اعتبارسنجی و بروزرسانی پیش فاکتور
    }

    public function destroy($id)
    {
        // حذف پیش فاکتور
    }
}
