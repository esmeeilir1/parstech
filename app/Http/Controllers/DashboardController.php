<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\Income;
use App\Models\Expense;
use Morilog\Jalali\Jalalian; // اضافه شد

class DashboardController extends Controller
{
    public function index()
    {
        $customers_count = Customer::count();
        $total_income = Income::sum('amount');
        $total_expense = Expense::sum('amount');

        // آرایه ماه‌های شمسی با استفاده از Jalalian
        $income_months = [];
        $income_values = [];
        $expense_months = [];
        $expense_values = [];

        foreach(range(1,6) as $month) {
            $date = now()->startOfYear()->addMonths($month-1);
            $income_months[] = Jalalian::fromDateTime($date)->format('%B');
            $income_values[] = Income::whereMonth('created_at', $date->month)->sum('amount');
            $expense_months[] = Jalalian::fromDateTime($date)->format('%B');
            $expense_values[] = Expense::whereMonth('created_at', $date->month)->sum('amount');
        }

        return view('dashboard', compact(
            'customers_count', 'total_income', 'total_expense',
            'income_months', 'income_values',
            'expense_months', 'expense_values'
        ));
    }
}
