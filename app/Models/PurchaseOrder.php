<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'status',
    ];

    // Relationship with purchase order items
    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    // Relationship with supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Relationship with images
    public function images()
    {
        return $this->hasMany(PurchaseOrderImage::class);
    }

    // Calculate the total cost for the entire purchase order
    public function getTotalCostAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->product?->cost * $item->ordered_quantity ?? 0;
        });
    }

    // Calculate the total received quantities
    public function getTotalReceivedQuantitiesAttribute()
    {
        return $this->items->sum('received_quantity');
    }
}