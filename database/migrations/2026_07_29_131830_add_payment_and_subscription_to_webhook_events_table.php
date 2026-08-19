<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('webhook_events', function (Blueprint $table) {

            $table->foreignId('payment_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('subscription_id')
                ->nullable()
                ->after('payment_id')
                ->constrained()
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('webhook_events', function (Blueprint $table) {

            $table->dropForeign(['payment_id']);
            $table->dropForeign(['subscription_id']);

            $table->dropColumn([
                'payment_id',
                'subscription_id'
            ]);

        });
    }
};