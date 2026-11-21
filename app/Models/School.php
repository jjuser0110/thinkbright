<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory;
	use SoftDeletes;
	protected $fillable = [
        'name',
        'transport_fee',
    ];

    protected $casts = [
        'transport_fee' => 'decimal:2',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
