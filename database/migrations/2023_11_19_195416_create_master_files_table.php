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
        Schema::create('master_files', function (Blueprint $table) {
           // master of items and defined by Admin to used on distrubutors stores later

            $table->id();
            $table->string('item_code');
            $table->text('description');
            $table->float('retail_price')->default(0);
            $table->boolean('is_active')->default(1);
            $table->integer('createdBy_id')->unsigned();
            $table->integer('lastEditBy_id')->unsigned()->nullable();
            $table->integer('sub_category_id')->unsigned();

            $table->softDeletes(); // Add this line to enable soft deletes

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_files');
    }
};
