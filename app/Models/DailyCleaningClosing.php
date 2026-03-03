<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyCleaningClosing extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'closing_date',
        'no_of_customer',
        'new_customer',
        'cleaning_count',
        'total_sales',
        'total_sst',
        'after_sst',
        'cleaning_tool',
        'expenses',
        'salary',
        'profit',
    ];
}

            