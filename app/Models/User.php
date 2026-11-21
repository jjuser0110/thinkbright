<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'ic',
        'contact',
        'username',
        'is_active',
        'shortname',
        'bank_id',
        'bank_account',
        'no_of_annual_leave',
        'no_of_sick_leave',
        'basic_salary',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'basic_salary' => 'decimal:2',
    ];

    /** One-to-one classes this user teaches. */
    public function oneToOneClasses()
    {
        return $this->hasMany(OneToOneClass::class, 'teacher_id');
    }

    /** Commission earned from one-to-one classes running in the given month. */
    public function oneToOneCommission(int $year, int $month): float
    {
        return round($this->oneToOneClasses()->activeInMonth($year, $month)->get()
            ->sum(fn ($c) => $c->commissionAmount()), 2);
    }

    public function leaveApplications()
    {
        return $this->hasMany(LeaveApplication::class);
    }

    /** Yearly entitlement in days for 'annual' or 'sick' leave. */
    public function leaveEntitlement(string $type): float
    {
        return (float) ($type === 'sick' ? $this->no_of_sick_leave : $this->no_of_annual_leave);
    }

    /** Approved leave days taken in a year (default: this year), by start date. */
    public function leaveUsed(string $type, ?int $year = null): float
    {
        return (float) $this->leaveApplications()
            ->where('type', $type)
            ->where('status', 'approved')
            ->whereYear('start_date', $year ?? now()->year)
            ->sum('days');
    }

    /** Days still available this year (entitlement minus approved leave). */
    public function leaveBalance(string $type, ?int $year = null): float
    {
        return $this->leaveEntitlement($type) - $this->leaveUsed($type, $year);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'superadmin'], true);
    }

    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    public function scopeTeachers($query)
    {
        return $query->where('role', 'teacher');
    }

    public function scopeAdmins($query)
    {
        return $query->whereIn('role', ['admin', 'superadmin']);
    }

    public function routeNotificationForWhatsApp()
    {
        return $this->contact;
    }
}
