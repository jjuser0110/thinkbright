<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salary extends Model
{
    use HasFactory;
	use SoftDeletes;
	protected $fillable = [
        'user_id',
        'payment_date',
        'basic',
        'overtime',
        'commission',
        'allowances',
        'extra',
        'gross_pay',
        'epf',
        'socso',
        'advance',
        'income_tax',
        'total_deduction',
        'reimbursement',
        'total_additions',
        'net_pay',
        'employer_epf',
        'employer_socso',
        'employer_s_p',
        'total_contribution',
        'employer_total_paid',  
        'remarks', 
        'month', 
        'year', 
        'year_month', 
        'employee_s_p'
    ];

    
    
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
