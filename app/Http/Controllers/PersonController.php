<?php

namespace App\Http\Controllers;
use Morilog\Jalali\Jalalian;
use App\Models\Person;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Province;
class PersonController extends Controller
{
    public function index()
    {
        $persons = Person::latest()->paginate(10);
        return view('persons.index', compact('persons'));
    }

public function create()
{
    $provinces = \App\Models\Province::all();
    return view('persons.create', compact('provinces'));
}

public function store(Request $request)
{

    \Log::info('DATE_INPUTS', [
    'birth_date' => $request->birth_date,
    'marriage_date' => $request->marriage_date,
    'join_date' => $request->join_date,
]);

    // تبدیل تاریخ شمسی به میلادی (اگر از jalalian استفاده می‌کنی)
foreach (['join_date', 'birth_date', 'marriage_date'] as $dateField) {
    if ($request->has($dateField) && $request->$dateField) {
        try {
            // اگر تاریخ - داشت (YYYY-MM-DD)، همان قبلی
            if (strpos($request->$dateField, '-') !== false) {
                $request[$dateField] = \Morilog\Jalali\Jalalian::fromFormat('Y-m-d', $request->$dateField)->toCarbon()->toDateString();
            }
            // اگر تاریخ / داشت (YYYY/MM/DD)
            elseif (strpos($request->$dateField, '/') !== false) {
                $request[$dateField] = \Morilog\Jalali\Jalalian::fromFormat('Y/m/d', $request->$dateField)->toCarbon()->toDateString();
            }
        } catch (\Exception $e) {
            $request[$dateField] = null;
        }
    }
}

    // اعتبارسنجی
    $rules = [
        'accounting_code' => 'required|string',
        'type' => 'required|in:customer,supplier,shareholder,employee',
        'province' => 'required|exists:provinces,id',
        'city' => 'required|exists:cities,id',
        'address' => 'required|string',
        'country' => 'required|string',
    ];

    // اگر تامین‌کننده (شرکت) بود فقط company_name اجباری شود
    if ($request->input('type') == 'supplier') {
        $rules['company_name'] = 'required|string';
    } else {
        $rules['first_name'] = 'required|string';
        $rules['last_name'] = 'required|string';
    }

    // فیلدهای اختیاری دیگر
    $optionalFields = [
        'nickname', 'credit_limit', 'price_list', 'tax_type', 'national_code', 'economic_code',
        'registration_number', 'branch_code', 'description', 'postal_code', 'phone', 'mobile', 'fax',
        'phone1', 'phone2', 'phone3', 'email', 'website', 'birth_date', 'marriage_date', 'join_date',
        'company_name', 'title'
    ];
    foreach ($optionalFields as $field) {
        $rules[$field] = 'nullable';
    }

    $validated = $request->validate($rules);

    try {
        DB::beginTransaction();

        // فقط اطلاعات شخص را ذخیره کن (بدون bank_accounts)
        $person = Person::create($request->except(['bank_accounts']));

        // ذخیره حساب‌های بانکی (اگر ارسال شده)
        if ($request->has('bank_accounts')) {
            $bankAccounts = [];
            foreach ($request->bank_accounts as $account) {
                if (!empty($account['bank_name'])) {
                    $bankAccounts[] = [
                        'bank_name' => $account['bank_name'],
                        'branch' => $account['branch'] ?? null,
                        'account_number' => $account['account_number'] ?? null,
                        'card_number' => $account['card_number'] ?? null,
                        'iban' => $account['iban'] ?? null,
                    ];
                }
            }
            if (!empty($bankAccounts)) {
                $person->bankAccounts()->createMany($bankAccounts);
            }
        }

        DB::commit();
        return redirect()->route('persons.index')->with('success', 'شخص جدید با موفقیت ایجاد شد.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'خطا در ثبت اطلاعات: ' . $e->getMessage())->withInput();
    }
}

    public function show(Person $person)
    {
        return view('persons.show', compact('person'));
    }

    public function edit(Person $person)
    {
        return view('persons.edit', compact('person'));
    }

    public function update(Request $request, Person $person)
    {
        $request->validate([
            'accounting_code' => 'required|string|max:255|unique:persons,accounting_code,' . $person->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'type' => 'required|in:customer,supplier,shareholder,employee',
            'national_code' => 'nullable|string|size:10|unique:persons,national_code,' . $person->id,
            'mobile' => 'nullable|string|max:11',
            'join_date' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $person->update($request->all());

            // به‌روزرسانی حساب‌های بانکی
            if ($request->has('bank_accounts')) {
                // حذف حساب‌های قبلی
                $person->bankAccounts()->delete();

                // افزودن حساب‌های جدید
                $bankAccounts = [];
                for ($i = 0; $i < count($request->bank_accounts['bank_name']); $i++) {
                    if (!empty($request->bank_accounts['bank_name'][$i])) {
                        $bankAccounts[] = [
                            'bank_name' => $request->bank_accounts['bank_name'][$i],
                            'account_number' => $request->bank_accounts['account_number'][$i],
                            'card_number' => $request->bank_accounts['card_number'][$i],
                            'iban' => $request->bank_accounts['iban'][$i],
                        ];
                    }
                }
                $person->bankAccounts()->createMany($bankAccounts);
            }

            DB::commit();
            return redirect()->route('persons.index')
                ->with('success', 'اطلاعات شخص با موفقیت به‌روزرسانی شد.');

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'خطا در به‌روزرسانی اطلاعات: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Person $person)
    {
        try {
            DB::beginTransaction();

            // حذف حساب‌های بانکی مرتبط
            $person->bankAccounts()->delete();

            // حذف شخص
            $person->delete();

            DB::commit();
            return redirect()->route('persons.index')
                ->with('success', 'شخص با موفقیت حذف شد.');

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'خطا در حذف اطلاعات: ' . $e->getMessage());
        }
    }

    public function customers()
    {
        $persons = Person::where('type', 'customer')->latest()->paginate(10);
        return view('persons.customers', compact('persons'));
    }

    public function suppliers()
    {
        $persons = Person::where('type', 'supplier')->latest()->paginate(10);
        return view('persons.suppliers', compact('persons'));
    }

    public function sellersIndex()
    {
        $persons = Person::where('type', 'seller')->latest()->paginate(10);
        return view('persons.sellers.index', compact('persons'));
    }

    public function sellersPage()
    {
        return view('persons.sellers.page');
    }

public function getNextCode()
{
    try {
        // فقط کدهایی که مثل person-12345 هستند را انتخاب کن
        $lastPerson = \App\Models\Person::where('accounting_code', 'REGEXP', '^person-[0-9]+$')
            ->orderByRaw('CAST(SUBSTRING(accounting_code, 8) AS UNSIGNED) DESC')
            ->first();

        $nextNumber = 10001;
        if ($lastPerson) {
            $lastNumber = intval(substr($lastPerson->accounting_code, 7));
            $nextNumber = $lastNumber + 1;
        }
        $nextCode = 'person-' . $nextNumber;
        return response()->json(['code' => $nextCode]);
    } catch (\Exception $e) {
        \Log::error('Error in getNextCode: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function rules()
{
    return [
        'accounting_code' => 'required|string',
        'type' => 'required|in:customer,supplier,shareholder,employee',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'province' => 'required|exists:provinces,id',
        'city' => 'required|exists:cities,id',
        'address' => 'required|string',
        'country' => 'required|string',
        // اگر فیلدهای مهم دیگه‌ای داری همینجا اضافه کن
        // 'company_name' => 'required|string',
        // 'title' => 'required|string',
        // ...
    ];
}

    public function searchAjax(Request $request)
    {
        $term = $request->input('q');
        $query = \App\Models\Person::query();

        if ($term) {
            $query->where('first_name', 'like', "%$term%")
                ->orWhere('last_name', 'like', "%$term%")
                ->orWhere('accounting_code', 'like', "%$term%");
        }

        $persons = $query->limit(20)->get();

        $results = [];
        foreach ($persons as $person) {
            $results[] = [
                'id' => $person->id,
                'first_name' => $person->first_name,
                'last_name' => $person->last_name,
                'person_type' => $person->type ?? '', // اگر فیلد type داری (نوع شخص)
                'accounting_code' => $person->accounting_code ?? '',
                // اگر فیلد type نداری، مقدار دیگری بگذار یا حذف کن
                'text' => '', // باید خالی باشد تا ظاهر html را خودمان در JS بسازیم
            ];
        }

        return response()->json(['results' => $results]);
    }
}
