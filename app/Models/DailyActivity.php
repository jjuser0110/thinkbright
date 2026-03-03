<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyActivity extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'daily_activity_no',
        'daily_activity_date',
        'line',
        'leader_id',
        'operator_ids',
        'number_of_worker',
        'sales_total',
        'expenses_total',
        'expenses_total_per_pax',
        'salary',
        'profit',
        'status',
    ];

    protected $casts = [
        'operator_ids' => 'array',
    ];

    public function items()
    {
        return $this->hasMany('App\Models\DailyActivityItem');
    }

    public function salaries()
    {
        return $this->hasMany('App\Models\WorkerSalary');
    }

    public function leader()
    {
        return $this->belongsTo('App\Models\User', 'leader_id');
    }
    
    public function getOperatorNamesAttribute()
    {
        if (empty($this->operator_ids)) {
            return '';
        }

        $operators = \App\Models\User::whereIn('id', $this->operator_ids)->pluck('name')->toArray();
        return implode(', ', $operators);
    }
}
