<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('webhook_events', function (Blueprint $table) {

            $table->string('stripe_session_id')->nullable()->after('stripe_event_id');

            $table->string('stripe_payment_intent_id')->nullable()->after('stripe_session_id');

            $table->string('stripe_subscription_id')->nullable()->after('stripe_payment_intent_id');

            $table->string('stripe_invoice_id')->nullable()->after('stripe_subscription_id');
        });
    }

    public function down(): void
    {
        Schema::table('webhook_events', function (Blueprint $table) {

            $table->dropColumn([
                'stripe_session_id',
                'stripe_payment_intent_id',
                'stripe_subscription_id',
                'stripe_invoice_id',
            ]);

        });
    }
};