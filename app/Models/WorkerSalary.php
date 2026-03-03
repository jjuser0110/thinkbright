<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkerSalary extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'daily_activity_id',
        'user_id',
        'salary_type',
        'salary_amount',
        'normal',
        'overtime',
        'daily_date',
    ];

    public function worker()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}