<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
	use SoftDeletes;
	protected $fillable = [
        'month',
        'year',
        'title',
        'description',
        'amount'
    ];

    
    public function getMonthNameAttribute(){
        return date("F", mktime(0, 0, 0, $this->month, 10));
    }
}
