<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SellerController extends Controller
{
    public function create()
    {
        $nextCode = $this->getNextSellerCode();
        return view('sellers.create', compact('nextCode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'seller_code' => 'required|string|max:255|unique:sellers,seller_code',
            // سایر فیلدها:
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:15',
            'company_name' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'national_code' => 'nullable|string|max:20',
            'economic_code' => 'nullable|string|max:20',
            'registration_number' => 'nullable|string|max:30',
            'branch_code' => 'nullable|string|max:30',
            'description' => 'nullable|string',
            'country' => 'nullable|string|max:50',
            'province' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'email' => 'nullable|string|max:191',
            'website' => 'nullable|string|max:191',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|string|max:20',
            'marriage_date' => 'nullable|string|max:20',
            'join_date' => 'nullable|string|max:20',
            'credit_limit' => 'nullable|numeric',
            'price_list' => 'nullable|string|max:100',
            'tax_type' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sellers', 'public');
        }

        $data['code_editable'] = $request->has('code_editable') ? true : false;

        $seller = Seller::create($data);

        if ($request->has('bank_accounts.bank_name')) {
        $bankAccounts = [];
        foreach ($request->bank_accounts['bank_name'] as $i => $bankName) {
            if (!$bankName && !$request->bank_accounts['account_number'][$i] && !$request->bank_accounts['card_number'][$i]) continue;
            $bankAccounts[] = [
                'bank_name'      => $bankName,
                'account_number' => $request->bank_accounts['account_number'][$i],
                'card_number'    => $request->bank_accounts['card_number'][$i],
                'iban'           => $request->bank_accounts['iban'][$i] ?? null,
            ];
        }
        $seller->bankAccounts()->createMany($bankAccounts);
    }
        // ذخیره حساب‌های بانکی (اختیاری، اگر بانک را جدا مدل‌سازی کردی اینجا اضافه کن)

        return redirect()->route('sellers.index')->with('success', 'فروشنده با موفقیت ایجاد شد.');
    }

    // تولید کد بعدی فروشنده
    public function nextCode()
    {
        return response()->json(['code' => $this->getNextSellerCode()]);
    }

    // الگوریتم کد فروشنده
    private function getNextSellerCode()
    {
        $last = Seller::orderBy('id', 'desc')->first();
        if (!$last) return 'Seller-10001';

        $lastCode = $last->seller_code;
        // اگر کد قبلی عددی بود:
        if (preg_match('/Seller-(\d+)/', $lastCode, $m)) {
            return 'Seller-' . ((int)$m[1] + 1);
        } else {
            // اگر قبلی غیرعددی بود، یک عدد جدید پیدا کن
            $maxNum = Seller::whereRaw("seller_code REGEXP '^Seller-[0-9]+$'")
                ->selectRaw("MAX(CAST(SUBSTRING(seller_code,8) AS UNSIGNED)) as max_num")
                ->value('max_num');
            return 'Seller-' . ($maxNum ? $maxNum + 1 : 10001);
        }
    }

    public function index()
    {
        $sellers = Seller::latest()->paginate(10);
        return view('sellers.index', compact('sellers'));
    }

    public function show(\App\Models\Seller $seller)
    {
        // اگر مدل بانک حساب‌ها را داری و relation را تعریف کردی، این خط کافی است
        return view('sellers.show', compact('seller'));

        // اگر نه، می‌توانی به صورت دستی بارگذاری کنی


    }
    public function edit(\App\Models\Seller $seller)
    {
        // اگر نیاز به nextCode نداری همین کافیست
        return view('sellers.edit', compact('seller'));
    }
    public function update(Request $request, \App\Models\Seller $seller)
    {
    $request->validate([
        // ... ولیدیشن مثل store
        'seller_code' => 'required|string|max:255|unique:sellers,seller_code,' . $seller->id,
        'image' => 'nullable|image|max:2048',
        // سایر فیلدها
    ]);

    $data = $request->all();
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('sellers', 'public');
    }
    $data['code_editable'] = $request->has('code_editable') ? true : false;
    $seller->update($data);

    // حساب‌های بانکی: حذف قبلی و ثبت جدید مثل store (در صورت نیاز)
    $seller->bankAccounts()->delete();
    if ($request->has('bank_accounts.bank_name')) {
        $bankAccounts = [];
        foreach ($request->bank_accounts['bank_name'] as $i => $bankName) {
            if (!$bankName && !$request->bank_accounts['account_number'][$i] && !$request->bank_accounts['card_number'][$i]) continue;
            $bankAccounts[] = [
                'bank_name'      => $bankName,
                'account_number' => $request->bank_accounts['account_number'][$i],
                'card_number'    => $request->bank_accounts['card_number'][$i],
                'iban'           => $request->bank_accounts['iban'][$i] ?? null,
            ];
        }
        $seller->bankAccounts()->createMany($bankAccounts);
    }

    return redirect()->route('sellers.index')->with('success', 'ویرایش فروشنده با موفقیت انجام شد.');
    }
// گرفتن لیست فروشنده‌ها برای نمایش در فاکتور جدید
public function list()
{
    // فقط id و نام فروشنده (نام + نام خانوادگی یا فقط یکی) را برگردان
    $sellers = \App\Models\Seller::select('id', 'first_name', 'last_name', 'nickname')
        ->orderBy('first_name')
        ->get();

    $result = $sellers->map(function($s) {
        $name = trim($s->first_name . ' ' . $s->last_name);
        if(!$name && $s->nickname) $name = $s->nickname;
        if(!$name) $name = 'بدون نام';
        return [
            'id' => $s->id,
            'text' => $name
        ];
    });
    return response()->json($result);
}
}

