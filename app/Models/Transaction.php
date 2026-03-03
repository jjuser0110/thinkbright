<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'date',
        'bank_account_id',
        'type',
        'description',
        'amount',
        'remarks'
    ];

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
}
