<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('purchase_order_images', function (Blueprint $table) {
        $table->id();
        $table->foreignId('purchase_order_id')->constrained()->onDelete('cascade'); // Foreign key to purchase_orders
        $table->string('image'); // Path to the image
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('purchase_order_images');
}
};
