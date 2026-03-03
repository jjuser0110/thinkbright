<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyCleaning extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'daily_cleaning_no',
        'daily_cleaning_date',
        'driver_id',
        'cleaner_ids',
        'address',
        'customer_name',
        'customer_contact',
        'start_time',
        'end_time',
        'sales',
        'profit',
        'sst_amount',
        'duration_hours',
        'checked',
    ];

    protected $casts = [
        'cleaner_ids' => 'array',
    ];

    public function driver()
    {
        return $this->belongsTo('App\Models\User', 'driver_id');
    }
    
    public function getCleanerNamesAttribute()
    {
        if (empty($this->cleaner_ids)) {
            return '';
        }

        $cleaners = \App\Models\User::whereIn('id', $this->cleaner_ids)->pluck('name')->toArray();
        return implode(', ', $cleaners);
    }
}

            