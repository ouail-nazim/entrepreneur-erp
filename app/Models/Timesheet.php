<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timesheet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contact_id',
        'date',
        'quantity',
        'comment',
        'status',
        'validated_by',
        'validated_at',
    ];

    protected $casts = [
        'date' => 'date',
        'quantity' => 'decimal:2',
        'validated_at' => 'datetime',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}
