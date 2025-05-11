<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankCard extends Model
{
    use HasFactory;

    protected $fillable = ['card_number'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
