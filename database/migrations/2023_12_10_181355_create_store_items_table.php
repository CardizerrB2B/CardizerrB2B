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
        Schema::create('store_items', function (Blueprint $table) {
           // for one valid usage item by adding & purchasing  processes & movements (tracking)
           $table->id();
           $table->unsignedBigInteger('master_store_id');
           $table->unsignedBigInteger('PO_id');
           $table->string('product_secure_type_value')->nullable();//added by charger
           $table->unsignedBigInteger('charger_id')->nullable();
           $table->boolean('isCharger')->default(0);
           $table->date('charger_date')->nullable();


           $table->boolean('sales_order_id')->nullable();
           $table->unsignedBigInteger('merchant_id')->nullable();

           $table->boolean('isSold')->default(0);
           $table->date('sold_date')->nullable();
           $table->softDeletes(); // Add this line to enable soft deletes
           
           $table->timestamps();


           $table->foreign('PO_id')->references('id')->on('purchase_orders');
           $table->foreign('master_store_id')->references('id')->on('master_stores');
           $table->foreign('charger_id')->references('id')->on('users');
           $table->foreign('merchant_id')->references('id')->on('users');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_items');
    }
};
