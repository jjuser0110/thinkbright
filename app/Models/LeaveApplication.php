<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    public const TYPES = ['annual' => 'Annual leave', 'sick' => 'Sick leave'];

    protected $fillable = [
        'user_id', 'type', 'start_date', 'end_date', 'days', 'reason',
        'status', 'approved_by', 'approved_at', 'admin_remarks',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime',
        'days' => 'decimal:1',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function typeLabel(): string
    {
        return __(self::TYPES[$this->type] ?? $this->type);
    }

    public function dateRange(): string
    {
        return $this->start_date->equalTo($this->end_date)
            ? $this->start_date->format('d M Y')
            : $this->start_date->format('d M').' – '.$this->end_date->format('d M Y');
    }

    /** Number of working days (Monday to Friday) between two dates, inclusive. */
    public static function workingDays(CarbonInterface $start, CarbonInterface $end): int
    {
        return collect(CarbonPeriod::create($start, $end))->filter(fn ($d) => ! $d->isWeekend())->count();
    }
}
