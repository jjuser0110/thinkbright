<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    use HasFactory;
	use SoftDeletes;
	protected $fillable = [
        'month',
        'year',
        'date_of_food',
        'food_type_id',
        'quantity',
        'total',
    ];
    
    public function food_type()
    {
        return $this->belongsTo('App\Models\FoodType','food_type_id');
    }
}
