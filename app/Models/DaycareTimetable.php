<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaycareTimetable extends Model
{
    /** ISO weekday number => English name (translated in views with __()). */
    public const DAYS = [1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday'];

    protected $fillable = ['day', 'start_time', 'end_time', 'activity', 'teacher_id', 'remarks'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function timeRange(): string
    {
        return substr($this->start_time, 0, 5).' – '.substr($this->end_time, 0, 5);
    }

    /** All slots grouped by day (1-5), each day sorted by start time. */
    public static function weekly()
    {
        $slots = static::with('teacher')->orderBy('start_time')->get()->groupBy('day');

        return collect(self::DAYS)->mapWithKeys(fn ($name, $day) => [$day => $slots->get($day, collect())]);
    }
}
