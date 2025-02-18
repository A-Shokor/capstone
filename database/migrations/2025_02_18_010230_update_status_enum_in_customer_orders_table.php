<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateStatusEnumInCustomerOrdersTable extends Migration
{
    public function up()
    {
        DB::statement("
            ALTER TABLE customer_orders
            MODIFY status ENUM('preparing', 'ready', 'scheduled', 'delivering', 'delivered', 'received', 'canceled')
        ");
    }

    public function down()
    {
        DB::statement("
            ALTER TABLE customer_orders
            MODIFY status ENUM('preparing', 'ready', 'scheduled', 'delivering', 'delivered', 'received')
        ");
    }
}