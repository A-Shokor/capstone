<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{
    use HasFactory;

    // Specify the fields that can be mass-assigned
    protected $fillable = [
        'customer_id', // Add this line
        'status',
        'total_price', // If applicable
    ];

    // Define the relationship to the Customer model
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Define the relationship to the CustomerOrderItem model
    public function items()
    {
        return $this->hasMany(CustomerOrderItem::class, 'customer_order_id');
    }
}