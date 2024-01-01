<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('SO_id');
            $table->unsignedBigInteger('store_item_id');
            $table->unsignedBigInteger('master_store_id');
            $table->string('item_code');
            $table->unsignedBigInteger('product_secure_type_id'); //(login - serial number - filed)
            $table->string('product_secure_type_value')->nullable();

            $table->float('item_price')->default(1);

            $table->foreign('SO_id')->references('id')->on('sales_orders');
            $table->foreign('store_item_id')->references('id')->on('store_items');
            $table->foreign('master_store_id')->references('id')->on('master_stores');
            $table->foreign('product_secure_type_id')->references('id')->on('product_secure_types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_details');
    }
};
