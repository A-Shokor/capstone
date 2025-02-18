<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrderItem extends Model
{
    use HasFactory;

    // Specify the fields that can be mass-assigned
    protected $fillable = [
        'customer_order_id', // Add this line
        'product_id',       // Add this line
        'quantity',         // Add this line
    ];

    // Define the relationship to the CustomerOrder model
    public function order()
    {
        return $this->belongsTo(CustomerOrder::class, 'customer_order_id');
    }

    // Define the relationship to the Product model
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}