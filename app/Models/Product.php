<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'category_id', 'brand_id', 'code', 'image', 'gallery', 'video', 'short_desc',
        'description', 'stock', 'min_stock', 'unit', 'weight', 'buy_price', 'sell_price',
        'discount', 'barcode', 'store_barcode', 'is_active', 'attributes'
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_active' => 'boolean'
    ];

    public function category() {
        return $this->belongsTo(Category::class);

    }
    public function brand() {
        return $this->belongsTo(Brand::class);
        return $this->belongsTo(\App\Models\Brand::class, 'brand_id');
    }
    public static function generateProductCode()
    {
        $lastProduct = self::orderBy('id', 'desc')->first();
        $id = $lastProduct ? $lastProduct->id + 1 : 100001;
        return 'products-' . $id;
    }



}
