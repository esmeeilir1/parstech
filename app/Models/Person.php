<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
    'accounting_code', 'type', 'first_name', 'last_name', 'nickname', 'credit_limit', 'price_list', 'tax_type',
    'national_code', 'economic_code', 'registration_number', 'branch_code', 'description', 'address', 'country',
    'province', 'city', 'postal_code', 'phone', 'mobile', 'fax', 'phone1', 'phone2', 'phone3', 'email', 'website',
    'birth_date', 'marriage_date', 'join_date', 'company_name', 'title'
];

    protected $table = 'persons';

  public function bankAccounts()
{
    return $this->hasMany(\App\Models\BankAccount::class, 'person_id');
}

    // اعتبارسنجی کد ملی
    public static function validateNationalCode($code)
    {
        if (!preg_match('/^[0-9]{10}$/', $code)) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += ((10 - $i) * intval(substr($code, $i, 1)));
        }

        $ret = $sum % 11;
        $parity = intval(substr($code, 9, 1));

        if ($ret < 2) {
            return $ret == $parity;
        }
        return (11 - $ret) == $parity;
    }
}
