<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'code', 'name', 'category_id', 'price', 'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
