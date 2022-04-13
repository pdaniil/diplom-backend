<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_items', function (Blueprint $table) {
            $table->id();
            $table->string('article');
            $table->string('brand');
            $table->string('description')->nullable();
            $table->string('title');
            $table->dateTime('delivery_date');
            $table->float('price');
            $table->integer('count');

            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('storage_id')->constrained('storages');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_items');
    }
}
