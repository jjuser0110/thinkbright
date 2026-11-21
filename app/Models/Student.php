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
        'daycare',
        'daycare_fee',
        'bath_lunch',
        'bath_lunch_fee',
        'transport',
        'transport_fee',
    ];

    protected $casts = [
        'daycare' => 'boolean',
        'bath_lunch' => 'boolean',
        'transport' => 'boolean',
        'daycare_fee' => 'decimal:2',
        'bath_lunch_fee' => 'decimal:2',
        'transport_fee' => 'decimal:2',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function displayName(): string
    {
        return trim($this->name.($this->c_name ? ' '.$this->c_name : ''));
    }

    /**
     * Effective monthly charges from this student's enrolment.
     * Custom amounts on the student win; otherwise Fee Setting (daycare, bath & lunch)
     * and the school's transport fee are used. Services not taken are 0.
     *
     * @return array{daycare: float, bath_lunch: float, transport: float, one_to_one: float, total: float}
     */
    public function monthlyCharges(): array
    {
        $daycare = $this->daycare ? (float) ($this->daycare_fee ?? Setting::daycareFee()) : 0.0;
        $bathLunch = $this->bath_lunch ? (float) ($this->bath_lunch_fee ?? Setting::bathLunchFee()) : 0.0;
        $transport = $this->transport ? (float) ($this->transport_fee ?? $this->school?->transport_fee ?? 0) : 0.0;
        $oneToOne = method_exists($this, 'oneToOneClasses')
            ? (float) $this->oneToOneClasses()->currentlyActive()->sum('monthly_fee')
            : 0.0;

        return [
            'daycare' => $daycare,
            'bath_lunch' => $bathLunch,
            'transport' => $transport,
            'one_to_one' => $oneToOne,
            'total' => $daycare + $bathLunch + $transport + $oneToOne,
        ];
    }

    /** True when transport is taken but neither the student nor the school has a fee set. */
    public function transportFeeMissing(): bool
    {
        return $this->transport && is_null($this->transport_fee) && is_null($this->school?->transport_fee);
    }
}
