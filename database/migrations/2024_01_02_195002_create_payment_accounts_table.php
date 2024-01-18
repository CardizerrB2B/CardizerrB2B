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
        Schema::create('payment_accounts', function (Blueprint $table) {
            $table->id();
                    
            $table->unsignedBigInteger('user_id');

            $table->string('bank_name');
            $table->string('account_number')->nullable();
            $table->string('IBAN')->nullable();
            $table->string('account_ownerName');

            $table->enum('status',['created','enabled','wrongData','expired','removal'])->default('created');
            $table->enum('verified',[0,1])->default(0);
            $table->datetime('verified_date')->nullable();

            $table->boolean('isRemoval')->default(0);

            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_accounts');
    }
};
