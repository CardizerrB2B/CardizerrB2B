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
           // for one valid usage item by adding & purchasing  processes
            $table->id();
            $table->integer('master_store_id')->unsigned();

            $table->string('product_secure_type_value');
            $table->integer('marchent_id')->unsigned()->nullable();
            $table->boolean('isSold')->default(0);
            $table->date('sold_date')->nullable();
            $table->softDeletes(); // Add this line to enable soft deletes

            $table->timestamps();
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
