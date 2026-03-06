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
    Schema::create('classes', function (Blueprint $table) {
        $table->id();
        $table->string('class_name');
        $table->string('level', 50);
        $table->integer('capacity');
        $table->foreignId('school_year_id')->constrained('school_years')->onDelete('cascade');
        $table->foreignId('teacher_id')->nullable()->constrained('teachers')->onDelete('set null');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
