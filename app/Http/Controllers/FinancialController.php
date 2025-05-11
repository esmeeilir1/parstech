<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinancialController extends Controller
{
    public function income()
    {
        return view('financial.income');
    }

    public function expenses()
    {
        return view('financial.expenses');
    }

    public function banking()
    {
        return view('financial.banking');
    }

    public function cheques()
    {
        return view('financial.cheques');
    }
}