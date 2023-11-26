<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('password')->nullable();
            $table->string('mobile_number')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('fullname');

            $table->enum('user_type', ['SA','Admin','Distributor','Marchent','Charger'])->default('Marchent');

            $table->integer('createdBy_id')->unsigned()->nullable();
            $table->integer('distributor_id')->unsigned()->nullable(); // if the user type is Marchent


            $table->timestamp('email_verified_at')->nullable();
        
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes(); // Add this line to enable soft deletes


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
