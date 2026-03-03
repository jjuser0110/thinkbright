<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CleanerKpi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'daily_cleaning_id',
        'user_id',
        'date',
        'time_from',
        'time_to',
        'duration_hours',
        'no_of_cleaner',
        'score',
    ];

    public function daily_cleaning()
    {
        return $this->belongsTo('App\Models\DailyCleaning');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
