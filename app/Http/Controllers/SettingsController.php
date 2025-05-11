<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function company()
    {
        return view('settings.company');
    }

    public function users()
    {
        return view('settings.users');
    }
}
