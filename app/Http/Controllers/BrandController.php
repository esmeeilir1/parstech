<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function create()
    {
        return view('brands.create');
    }

    // این متد را اضافه کن
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:brands,name',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('brands', 'public');
        }

        Brand::create($validated);

        return redirect()->route('brands.create')->with('success', 'برند جدید ثبت شد');
    }
}
