<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_orders', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Foreign key to link to the customers table
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');

            // Customer name (optional, nullable)
            $table->string('customer_name')->nullable();

            // Status of the order (e.g., preparing, ready, delivered)
            $table->string('status')->default('preparing');

            // Timestamps for created_at and updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_orders');
    }
}