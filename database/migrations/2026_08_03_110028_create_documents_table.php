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
    Schema::create('documents', function (Blueprint $table) {
        $table->id();
        $table->string('file_name');
        $table->string('file_path');
        // ↓ Yeh dono polymorphic ke liye zaroori hain
        $table->unsignedBigInteger('documentable_id');
        $table->string('documentable_type');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
