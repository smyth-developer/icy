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
        Schema::create('syllabi', function (Blueprint $table) {
            $table->id();
            $table->integer('ordering')->default(1000);
            $table->foreignId('subject_id')->constrained('subjects');
            $table->unsignedInteger('lesson_number');
            $table->string('content');
            $table->string('objectives');
            $table->string('vocabulary');
            $table->string('assignment');
            $table->string('student_task')->nullable();
            $table->string('lecturer_task')->nullable();
            $table->string('lecture_slide')->nullable();
            $table->string('audio_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syllabi');
    }
};
