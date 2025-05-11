<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'bank_name',
        'branch',
        'account_number',
        'card_number',
        'iban'
    ];

    public function person()
    {
        return $this->belongsTo(\App\Models\Person::class, 'person_id');
    }
}
