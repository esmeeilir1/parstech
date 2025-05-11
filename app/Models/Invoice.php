<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'number',
        // فیلدهای دیگر بر اساس جدولت
    ];
}
