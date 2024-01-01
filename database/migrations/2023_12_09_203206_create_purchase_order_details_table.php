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
        Schema::create('purchase_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('PO_id');
            $table->unsignedBigInteger('item_id');
            $table->string('item_code');
            $table->unsignedBigInteger('product_secure_type_id'); //(login - serial number - filed)


            $table->integer('QTY')->default(1);
            $table->float('item_price')->default(1);
            $table->float('total_price')->default(1);

       
            $table->foreign('PO_id')->references('id')->on('purchase_orders');
            $table->foreign('item_id')->references('id')->on('master_files');
            $table->foreign('product_secure_type_id')->references('id')->on('product_secure_types');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_details');
    }
};
