<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockLogsTable extends Migration
{
    public function up()
    {
        Schema::create('stock_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Link to products table
            $table->string('action'); // 'increment' or 'decrement'
            $table->integer('quantity'); // Quantity updated
            $table->string('reason')->nullable(); // Reason for decrement (optional)
            $table->timestamps(); // Timestamps for when the log was created
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_logs');
    }
}