<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function search(Request $request)
    {
        $term = $request->get('term', '');

        $customers = Customer::where('name', 'LIKE', '%' . $term . '%')
            ->orWhere('email', 'LIKE', '%' . $term . '%')
            ->limit(10)
            ->get();

        return response()->json($customers->map(function ($customer) {
            return [
                'id' => $customer->id,
                'text' => $customer->name . ' (' . $customer->email . ')',
            ];
        }));
    }
}
