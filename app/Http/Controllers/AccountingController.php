<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function journal()
    {
        return view('accounting.journal');
    }

    public function ledger()
    {
        return view('accounting.ledger');
    }

    public function balance()
    {
        return view('accounting.balance');
    }
}
