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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('mobility_id')->constrained()->cascadeOnDelete();
            $table->foreignId('class_teacher_id')->constrained('teachers');
            $table->foreignId('english_teacher_id')->constrained('teachers');
            $table->string('preferred_type'); // kratkodoba / dlouhodoba
            $table->string('status')->default('draft');
            $table->boolean('gdpr_consent')->default(false);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
            $table->unique(['student_id', 'mobility_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
