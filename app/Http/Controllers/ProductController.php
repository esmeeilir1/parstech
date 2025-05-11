<?php
namespace App\Http\Controllers;
use App\Models\Unit;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
{
    $product = \App\Models\Product::with(['category', 'brand'])->findOrFail($id);
    return view('products.show', compact('product'));
}
    public function index()
{
    $products = Product::with(['category', 'brand'])->latest()->paginate(20);
    // توجه کن: Service مدل مربوط به خدمات است و باید ساخته شده باشد
    $services = \App\Models\Service::with('category')->latest()->paginate(20);
    return view('products.index', compact('products', 'services'));
}
public function upload(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:5120'
    ]);
    $path = $request->file('file')->store('products', 'public');
    return response()->json(['path' => $path]);
}
public function create()
{
    $categories = \App\Models\Category::where('category_type', 'product')->get();
    $brands = \App\Models\Brand::all();
    $units = \App\Models\Unit::all();
    $default_code = \App\Models\Product::generateProductCode();
    return view('products.create', compact('categories', 'brands', 'units', 'default_code'));
}
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id'    => 'nullable|exists:brands,id',
            'code'        => 'required|unique:products,code',
            'image'       => 'nullable|image|max:2048',
            'gallery.*'   => 'nullable|image|max:2048',
            'video'       => 'nullable|file|mimetypes:video/mp4,video/x-m4v,video/*',
            'short_desc'  => 'nullable|max:500',
            'description' => 'nullable',
            'stock'       => 'nullable|integer|min:0',
            'min_stock'   => 'nullable|integer|min:0',
            'unit'        => 'nullable|string|max:20',
            'weight'      => 'nullable|numeric',
            'buy_price'   => 'nullable|numeric',
            'sell_price'  => 'nullable|numeric',
            'discount'    => 'nullable|numeric',
            'barcode'     => 'nullable|string|max:100',
            'store_barcode' => 'nullable|string|max:100',
            'is_active'   => 'nullable'
        ]);

        // ذخیره تصویر شاخص
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // گالری تصاویر
        if ($request->hasFile('gallery')) {
            $gallery_paths = [];
            foreach($request->file('gallery') as $gallery_img){
                $gallery_paths[] = $gallery_img->store('products/gallery','public');
            }
            $validated['gallery'] = json_encode($gallery_paths);
        }

        // ویدیو
        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('products/video','public');
        }

        // فیلد فعال بودن
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // ویژگی‌ها (attributes)
        if ($request->has('attributes')) {
            $validated['attributes'] = json_encode($request->input('attributes'));
        }

        // ذخیره محصول
        Product::create($validated);

        // بازگشت با نوتیفیکیشن موفقیت
        return redirect()->route('products.index')->with('success', 'محصول با موفقیت ذخیره شد.');
    }
public function search(Request $request)
{
    $q = trim($request->input('q'));
    if(!$q) return response()->json([]);

    // واژه‌ها را جدا کن (بر اساس فاصله)
    $words = preg_split('/\s+/', $q);

    $products = \App\Models\Product::with('category')
        ->where('is_active', 1)
        ->where(function($query) use ($words) {
            foreach ($words as $word) {
                $query->where(function($subQuery) use ($word) {
                    $subQuery->where('name', 'LIKE', "%{$word}%")
                        ->orWhere('code', 'LIKE', "%{$word}%")
                        ->orWhere('barcode', 'LIKE', "%{$word}%")
                        ->orWhere('description', 'LIKE', "%{$word}%")
                        ->orWhere('short_desc', 'LIKE', "%{$word}%");
                });
            }
        })
        ->limit(15)
        ->get();

    $products = $products->map(function($product) {
        return [
            'id'    => $product->id,
            'name'  => $product->name,
            'code'  => $product->code,
            'category_id' => $product->category_id,
            'category'    => $product->category ? $product->category->name : '',
            'stock' => $product->stock,
            'sell_price' => $product->sell_price,
            'image' => $product->image ? asset('storage/' . $product->image) : asset('img/product-default.png'),
        ];
    });

    return response()->json($products);
}
}
