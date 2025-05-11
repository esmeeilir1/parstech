<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
use Illuminate\Http\Request;
class InvoiceController extends Controller
{
    public function create()
    {
        // اینجا view صدور فاکتور را نمایش بده

        $currencies = \App\Models\Currency::orderBy('title')->get();

        return view('invoices.create', compact(/* سایر متغیرها , */ 'currencies'));
    }
public function getNextNumber()
{
    $last = Invoice::where('number', 'LIKE', 'invoices-%')
        ->whereRaw("number REGEXP '^invoices-[0-9]+$'")
        ->orderByRaw("CAST(SUBSTRING(number, 10) AS UNSIGNED) DESC")
        ->first();

    if ($last) {
        $lastNum = intval(substr($last->number, 9));
        $next = $lastNum + 1;
    } else {
        $next = 10001;
    }
    return response()->json(['number' => "invoices-$next"]);
}
}
