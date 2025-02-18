<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerOrdersTableToAllowNullTotalPrice extends Migration
{
    public function up()
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            $table->decimal('total_price', 8, 2)->nullable()->change(); // Allow null values
        });
    }

    public function down()
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            $table->decimal('total_price', 8, 2)->nullable(false)->change(); // Revert to NOT NULL
        });
    }
}