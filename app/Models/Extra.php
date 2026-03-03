<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extra extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'isseued_date',
        'amount',
        'created_by_id',
        'checked',
    ];

    public function created_by()
    {
        return $this->belongsTo('App\Models\User', 'created_by_id');
    }
}