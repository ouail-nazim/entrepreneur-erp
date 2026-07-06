<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supplier_id',
        'product_id',
        'purchase_date',
        'quantity',
        'purchase_price',
        'total',
        'invoice_number',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'purchase_price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected static function booted()
    {
        static::created(function ($purchase) {
            $product = $purchase->product;
            $product->current_stock += $purchase->quantity;
            $product->save();

            // Record movement
            $product->movements()->create([
                'type' => 'in',
                'quantity' => $purchase->quantity,
                'reference_type' => 'Purchase',
                'reference_id' => $purchase->id,
                'description' => __('purchases.purchase_from') . ': ' . ($purchase->supplier->name ?? 'N/A'),
            ]);
        });
    }
}
