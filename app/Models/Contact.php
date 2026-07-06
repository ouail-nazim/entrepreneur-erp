<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'nin',
        'insurance_number',
        'hire_date',
        'salary',
        'photo',
        'managed_by',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'salary' => 'decimal:2',
    ];

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    public function roles()
    {
        return $this->belongsToMany(ContactRole::class);
    }

    public function manager()
    {
        return $this->belongsTo(Contact::class, 'managed_by');
    }

    public function managedContacts()
    {
        return $this->hasMany(Contact::class, 'managed_by');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getDailyRateAttribute()
    {
        $workingDays = \App\Models\Setting::get('working_days_per_month', 22);
        return $this->salary / $workingDays;
    }
}
