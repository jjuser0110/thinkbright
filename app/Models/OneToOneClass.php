<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class OneToOneClass extends Model
{
    /** ISO weekday number => English name. */
    public const DAYS = [1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday'];

    protected $fillable = [
        'student_id', 'teacher_id', 'subject', 'day', 'start_time', 'end_time',
        'monthly_fee', 'commission_percent', 'start_date', 'end_date', 'is_active', 'remarks',
    ];

    protected $casts = [
        'monthly_fee' => 'decimal:2',
        'commission_percent' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /** Active and running on the given date (today by default). */
    public function scopeCurrentlyActive($query, ?CarbonInterface $date = null)
    {
        $date = ($date ?? now())->toDateString();

        return $query->where('is_active', true)
            ->whereDate('start_date', '<=', $date)
            ->where(fn ($q) => $q->whereNull('end_date')->orWhereDate('end_date', '>=', $date));
    }

    /** Active and running for at least part of the given month. */
    public function scopeActiveInMonth($query, int $year, int $month)
    {
        $first = Carbon::create($year, $month, 1)->startOfDay();
        $last = $first->copy()->endOfMonth();

        return $query->where('is_active', true)
            ->whereDate('start_date', '<=', $last)
            ->where(fn ($q) => $q->whereNull('end_date')->orWhereDate('end_date', '>=', $first));
    }

    public function commissionAmount(): float
    {
        return round((float) $this->monthly_fee * (float) $this->commission_percent / 100, 2);
    }

    public function dayName(): string
    {
        return __(self::DAYS[$this->day] ?? '');
    }

    public function timeRange(): string
    {
        return substr($this->start_time, 0, 5).' – '.substr($this->end_time, 0, 5);
    }

    /**
     * Upcoming sessions generated from the weekly slots of the given classes.
     *
     * @return Collection<int, array{date: Carbon, class: self}>
     */
    public static function upcomingSessions($classes, int $days = 7): Collection
    {
        $start = now()->startOfDay();
        $sessions = collect();

        for ($i = 0; $i < $days; $i++) {
            $date = $start->copy()->addDays($i);
            foreach ($classes as $class) {
                if ($class->day !== $date->dayOfWeekIso) continue;
                if ($class->start_date && $class->start_date->gt($date)) continue;
                if ($class->end_date && $class->end_date->lt($date)) continue;
                // Skip today's sessions that have already finished.
                if ($i === 0 && now()->format('H:i:s') > $class->end_time) continue;
                $sessions->push(['date' => $date, 'class' => $class]);
            }
        }

        return $sessions->sortBy(fn ($s) => $s['date']->format('Y-m-d').' '.$s['class']->start_time)->values();
    }
}
