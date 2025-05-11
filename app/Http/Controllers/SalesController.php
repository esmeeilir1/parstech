<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        return view('sales.index');
    }

    public function create()
    {
        return view('sales.create');
    }

    public function store(Request $request)
    {
        // اعتبارسنجی و ذخیره اطلاعات فروش
    }

    public function returns()
    {
        return view('sales.returns');
    }

    public function storeReturn(Request $request)
    {
        // اعتبارسنجی و ذخیره اطلاعات مرجوعی
    }
}
