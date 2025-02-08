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
    Schema::table('products', function (Blueprint $table) {
        $table->decimal('cost', 8, 2)->nullable()->after('price'); // Add a nullable column for the cost price
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('cost');
    });
}
};
