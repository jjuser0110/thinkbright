<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrintRecord extends Model
{
    use HasFactory;
	use SoftDeletes;
	protected $fillable = [
        'account_id',
        'content',
    ];

    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }
}
