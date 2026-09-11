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
        Schema::create('mobilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->string('destination');
            $table->string('type'); 
            $table->string('season');
            $table->unsignedTinyInteger('eligible_maturita_year');
            $table->unsignedTinyInteger('eligible_vocational_year');
            $table->date('starts_on');
            $table->date('ends_on');
            $table->date('deadline_application');
            $table->date('deadline_documents');
            $table->date('deadline_class_teacher');
            $table->date('deadline_english_teacher');
            $table->date('test_opens_on');
            $table->date('test_closes_on');
            $table->unsignedSmallInteger('quota');
            $table->string('status')->default('draft'); // draft / aktivní / uzavřená
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobilities');
    }
};
