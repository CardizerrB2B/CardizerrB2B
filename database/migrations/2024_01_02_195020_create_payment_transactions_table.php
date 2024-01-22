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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('apporvedRejectedby_id')->nullable();//the admin checks the attached transfer then aprroved it  

            $table->unsignedBigInteger('payment_account_id');//current payment account 
            $table->enum('type',['deposit','withdraw']); // payment type instead of wallet type
            $table->enum('status',['created','pending','approved','rejected'])->default('created');
            $table->string('rejected_note')->nullable();
            $table->float('amount');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('apporvedRejectedby_id')->references('id')->on('users');
            $table->foreign('payment_account_id')->references('id')->on('payment_accounts');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
