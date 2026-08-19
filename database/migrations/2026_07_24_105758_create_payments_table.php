<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('fee_id')->constrained()->cascadeOnDelete();
        $table->foreignId('student_id')->constrained('student_profiles')->cascadeOnDelete();
        $table->string('stripe_session_id')->nullable();
        $table->string('stripe_payment_id')->nullable();
        $table->decimal('amount', 10, 2);
        $table->string('currency')->default('usd');
        $table->string('status')->default('pending'); // pending, paid, failed
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};