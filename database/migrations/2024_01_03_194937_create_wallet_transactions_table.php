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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('payment_account_id');//current payment account 
            $table->unsignedBigInteger('wallet_detail_id'); // the destination / source of user wallet 
            $table->enum('type',['deposit','withdraw','pay','Wallet_transfer']);
            $table->enum('status',['created','pending','done'])->default('created');
            $table->float('amount');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('payment_account_id')->references('id')->on('payment_accounts');
            $table->foreign('wallet_detail_id')->references('id')->on('wallet_details');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
