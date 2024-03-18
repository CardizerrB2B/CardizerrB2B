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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('distributor_id');
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('store_id');


            $table->float('VAT')->default(0);
            $table->float('total')->default(0);
            
            $table->enum('status', ['created','invoiced','credit', 'canceled'])->default('created');

            $table->boolean('is_invoiced')->default('0'); //check if  order have invoice or not
            $table->boolean('is_credit')->default('0'); //check if   back invoice or not

            $table->boolean('finished')->default('0');

            $table->foreign('distributor_id')->references('id')->on('users');
            $table->foreign('merchant_id')->references('id')->on('users');
            $table->foreign('store_id')->references('id')->on('stores');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
