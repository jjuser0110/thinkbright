<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory;
	use SoftDeletes;
	protected $fillable = [
        'student_id',
        'account_month_id',
        'tuition',
        'tuition_extra',
        'food',
        'transport',
        'transport_extra',
        'deposit',
        'material',
        'registration',
        'extra',
        'extra_2',
        'total',
        'paid',
        'sent',
        'remarks',
        'receipt_no',
    ];

    public function month()
    {
        return $this->belongsTo('App\Models\AccountMonth','account_month_id');
    }

    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }

    public function print_records()
    {
        return $this->hasMany('App\Models\PrintRecord');
    }

    public function print_record()
    {
        return $this->hasOne('App\Models\PrintRecord')->latest();
    }
}
