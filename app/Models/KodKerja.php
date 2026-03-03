<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KodKerja extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'boss_amount',
        'worker_amount',
        'earn_amount',
        'is_active',
        'description',
    ];
}
