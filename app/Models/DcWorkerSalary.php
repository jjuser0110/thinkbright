<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DcWorkerSalary extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'daily_cleaning_closing_id',
        'user_id',
        'daily_date',
        'salary_type',
        'duration_hours',
        'normal',
        'overtime',
        'salary_amount',
    ];
}
