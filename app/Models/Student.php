<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
	use SoftDeletes;
	protected $fillable = [
        'name',
        'c_name',
        'dob',
        'ic',
        'level',
        'deposit',
        'class',
        'school_id',
        'parent_name',
        'parent_contact',
        'parent_relation',
        'parent_name_2',
        'parent_contact_2',
        'parent_relation_2',
        'is_active',
    ];

    public function school()
    {
        return $this->belongsTo('App\Models\School');
    }
}
