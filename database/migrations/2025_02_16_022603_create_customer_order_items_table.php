<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::create('customer_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_order_id')->constrained()->onDelete('cascade'); // Link to customer_orders table
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Link to products table
            $table->integer('quantity')->unsigned(); // Quantity of the product
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_order_items');
    }
}
