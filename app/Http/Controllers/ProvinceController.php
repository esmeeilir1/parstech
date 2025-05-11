<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function cities(Request $request, $province_id)
    {
        $cities = City::where('province_id', $province_id)
            ->orderBy('name')
            ->get(['id', 'name']);
        return response()->json($cities);
    }
}
