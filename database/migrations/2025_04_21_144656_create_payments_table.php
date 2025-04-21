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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->decimal('amount', 10, 2);
            $table->enum('method', ['cash', 'card', 'paypal', 'bank_transfer']);
            $table->string('transaction_id', 255)->nullable();
            $table->enum('status', ['pending', 'successful', 'failed', 'refunded'])->default('pending');
            $table->unsignedBigInteger('mode_payment_id');

            // Foreign key constraints
            $table->foreign('mode_payment_id')->references('id')->on('mode_payments');
            $table->foreign('booking_id')->references('id')->on('bookings');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
