<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_code', 'first_name', 'last_name', 'nickname', 'mobile', 'image', 'code_editable',
        'company_name', 'title', 'national_code', 'economic_code', 'registration_number', 'branch_code', 'description'
    ];
    public function bankAccounts()
    {
        return $this->hasMany(SellerBankAccount::class);
    }
}
