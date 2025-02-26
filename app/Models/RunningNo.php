<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RunningNo extends Model
{
    use HasFactory;
	use SoftDeletes;
	protected $fillable = [
        'year',
        'month',
        'increment_no',
    ];
}