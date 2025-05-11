<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShareholderController extends Controller
{
    public function index()
    {
        return view('shareholders.index');
    }
}
