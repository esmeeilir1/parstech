<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
public function index(Request $request)
{
    // اگر درخواست ajax بود، فقط json بده
    if ($request->ajax()) {
        // ارزهای فعال را مرتب برگردان
        return \App\Models\Currency::orderBy('title')->get();
    }
    // اگر صفحه می‌خواهی (معمولاً لازم نیست)
    $currencies = \App\Models\Currency::orderBy('title')->get();
    return view('currencies.index', compact('currencies'));
}

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:50',
            'symbol' => 'nullable|string|max:10',
            'code' => 'nullable|string|max:10',
        ]);
        $currency = Currency::create($request->only('title', 'symbol', 'code'));
        return response()->json(['success' => true, 'currency' => $currency]);
    }

public function update(Request $request, Currency $currency)
{
    $request->validate([
        'title' => 'required|string|max:50',
        'symbol' => 'nullable|string|max:10',
        'code' => 'nullable|string|max:10',
    ]);

    $currency->update([
        'title' => $request->title,
        'symbol' => $request->symbol,
        'code' => $request->code
    ]);

    return response()->json(['success' => true, 'currency' => $currency]);
}

    public function destroy(Currency $currency)
    {
        $currency->delete();
        return response()->json(['success' => true]);
    }
}
