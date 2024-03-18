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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->integer('distributor_id')->unsigned()->nullable(); // who created the invitation for his merchants
            $table->boolean('is_used')->default(0);
            $table->boolean('is_expired')->default(0); // if the invitation is not used within 15 minutes, it will be expired (not used and not expired are mutually exclusive
            $table->integer('used_by_id')->unsigned()->nullable(); // if the invitation is used by a merchant

            $table->string('invitation_token', 32)->unique()->nullable();
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
