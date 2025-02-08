<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'price',
        'cost', // Add this field
        'description',
        'barcode',
        'supplier_id',
    ];

    protected $casts = [
        'price' => 'decimal:2', // Cast price to a decimal with 2 decimal places
        'cost' => 'decimal:2',  // Cast cost to a decimal with 2 decimal places
    ];

    // Relationship with supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Relationship with purchase order items
    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
}
