<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'image',
    ];

    // Relationship with purchase order
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
