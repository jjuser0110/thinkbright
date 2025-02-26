<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountMonth extends Model
{
    use HasFactory;
	use SoftDeletes;
	protected $fillable = [
        'month',
        'year',
        'is_active',
    ];
    
    public function accounts()
    {
        return $this->hasMany('App\Models\Account');
    }

    public function getMonthNameAttribute(){
        return date("F", mktime(0, 0, 0, $this->month, 10));
    }
}
