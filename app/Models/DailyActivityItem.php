<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyActivityItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'daily_activity_id',
        'no_job_sheet',
        'nama_product',
        'kod_product',
        'kelompok_no',
        'quantity',
        'start_time',
        'end_time',
        'kod_kerja_id',
        'cost',
        'grand_cost',
        'price',
        'grand_price',
        'profit',
        'shift_type',
    ];

    public function daily_activity()
    {
        return $this->belongsTo('App\Models\DailyActivity');
    }

    public function kod_kerja()
    {
        return $this->belongsTo('App\Models\KodKerja');
    }
}
