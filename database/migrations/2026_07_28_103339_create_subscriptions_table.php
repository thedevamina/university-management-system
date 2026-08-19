<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('student_profiles')->cascadeOnDelete();
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_subscription_id')->nullable();
            $table->decimal('amount', 10, 2)->default(10000);
            $table->string('currency')->default('usd');
            $table->string('status')->default('incomplete'); // incomplete, active, past_due, canceled
            $table->timestamp('current_period_end')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};