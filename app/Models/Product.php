<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'reference',
        'description',
        'unit_price',
        'alert_threshold',
        'current_stock',
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function movements()
    {
        return $this->hasMany(ProductMovement::class);
    }
}
