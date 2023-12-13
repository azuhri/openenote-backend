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
        Schema::create('payment_qrs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("sender_id")->index();
            $table->foreign('sender_id')->references('id')->on('users');
            $table->unsignedBigInteger("receiver_id")->index();
            $table->foreign('receiver_id')->references('id')->on('users');
            $table->string("transaction_code")->index();
            $table->integer("amount");
            $table->string("status", 50);
            $table->timestamp("paid_at");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_q_r_s');
    }
};
