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
        Schema::create('master_stores', function (Blueprint $table) {
            $table->id();
            // master of items belongs to a distrubtor store 
            $table->integer('store_id')->unsigned();
            $table->integer('sub_category_id')->unsigned();
            $table->integer('product_secure_type_id')->unsigned(); //(login - serial number - filed)

            $table->integer('item_id');
            $table->string('item_code');
            $table->text('description');
            $table->float('QTY')->default(0);
            $table->float('last_cost')->default(0);
            $table->float('AVG_cost')->default(0);
            $table->float('stock_cost')->default(0);
            $table->float('retail_price')->default(0);
            $table->integer('createdBy_id')->unsigned();
            $table->integer('lastEditBy_id')->unsigned()->nullable();
   

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_stores');
    }
};
