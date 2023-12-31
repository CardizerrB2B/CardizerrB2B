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
            // master of items belongs to a distrubtor store , it have to get from PO
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('distributor_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->unsignedBigInteger('product_secure_type_id');//(login - serial number - field)

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
   
            $table->softDeletes(); // Add this line to enable soft deletes

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
