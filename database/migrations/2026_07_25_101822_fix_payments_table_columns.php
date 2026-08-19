<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('student_id')->after('fee_id')->constrained('student_profiles')->cascadeOnDelete();
            $table->renameColumn('session_id', 'stripe_session_id');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropColumn('student_id');
            $table->renameColumn('stripe_session_id', 'session_id');
        });
    }
};