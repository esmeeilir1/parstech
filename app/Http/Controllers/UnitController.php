<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['title' => 'required|unique:units,title']);
        $unit = Unit::create(['title' => $request->title]);
        return response()->json(['id' => $unit->id, 'title' => $unit->title]);
    }
}
