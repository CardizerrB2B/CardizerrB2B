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
        Schema::create('wallet_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('payment_account_id');

            $table->float('balance')->default(0);

            $table->enum('status',['created','enabled','suspended'])->default('created');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('payment_account_id')->references('id')->on('payment_accounts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_details');
    }
};
