<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained()->onDelete('cascade'); // PO relationship
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Product relationship
            $table->integer('ordered_quantity'); // Quantity ordered
            $table->integer('received_quantity')->default(0); // Quantity received
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_order_items');
    }
};
