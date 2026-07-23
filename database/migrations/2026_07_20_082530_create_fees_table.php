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
    Schema::create('fees', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')->constrained('student_profiles')->onDelete('cascade');
        $table->string('semester');
        $table->decimal('amount', 10, 2);
        $table->enum('status', ['unpaid', 'paid', 'overdue'])->default('unpaid');
        $table->date('due_date');
        $table->timestamp('paid_at')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
