<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // لیست دسته‌بندی‌ها با زیرمجموعه‌ها (لیستی)
    public function index()
    {
        // فقط دسته‌های والد (بدون والد) و با eager load زیر دسته‌ها
        $categories = \App\Models\Category::with('children')->whereNull('parent_id')->orderBy('category_type')->orderBy('name')->get();
        return view('categories.index', compact('categories'));
    }

    // فرم ایجاد (همان قبلی)
    public function create()
    {
        $personCategories = Category::where('category_type', 'person')->get();
        $productCategories = Category::where('category_type', 'product')->get();
        $serviceCategories = Category::where('category_type', 'service')->get();

        $nextPersonCode = 'per' . (Category::where('category_type', 'person')->count() + 1001);
        $nextProductCode = 'pro' . (Category::where('category_type', 'product')->count() + 1001);
        $nextServiceCode = 'ser' . (Category::where('category_type', 'service')->count() + 1001);

        return view('categories.create', compact(
            'personCategories', 'productCategories', 'serviceCategories',
            'nextPersonCode', 'nextProductCode', 'nextServiceCode'
        ));
    }
public function personSearch(Request $request)
{
    $query = $request->input('q');
    $categories = \App\Models\Category::whereIn('category_type', ['اشخاص', 'person']) // اینجا!
        ->where('name', 'like', "%$query%")
        ->limit(20)
        ->get(['id', 'name']);
    return response()->json($categories->map(function($cat){
        return ['id' => $cat->id, 'text' => $cat->name];
    }));
}
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'code' => 'nullable|string|max:100',
            'category_type' => 'required|in:person,product,service',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['name', 'code', 'category_type', 'parent_id', 'description']);
        if (empty($data['code'])) {
            $prefix = [
                'person' => 'per',
                'product' => 'pro',
                'service' => 'ser',
            ];
            $count = Category::where('category_type', $request->category_type)->count() + 1001;
            $data['code'] = $prefix[$request->category_type] . $count;
        }
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }
        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'دسته‌بندی جدید با موفقیت ایجاد شد.');
    }

    // فرم ویرایش
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::where('id', '!=', $category->id)
            ->where('category_type', $category->category_type)
            ->get();
        return view('categories.edit', compact('category', 'categories'));
    }

    // ذخیره ویرایش
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:191',
            'code' => 'nullable|string|max:100',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048'
        ]);
        $data = $request->only(['name', 'code', 'parent_id', 'description']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }
        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'دسته‌بندی با موفقیت ویرایش شد.');
    }

    // حذف
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        // اگر زیر دسته دارد، ابتدا همه زیر دسته‌ها را حذف یا parent_id را null کن یا ... (بستگی به نیاز)
        foreach ($category->children as $child) {
            $child->delete();
        }
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'دسته‌بندی با موفقیت حذف شد.');
    }
}
