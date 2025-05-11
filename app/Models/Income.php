<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id','title','amount','income_date','note'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
