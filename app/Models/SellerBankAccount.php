<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerBankAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'seller_id', 'bank_name', 'account_number', 'card_number', 'iban'
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
