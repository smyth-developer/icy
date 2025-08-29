<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. Lớp học
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->integer('ordering')->default(1000);
            $table->foreignId('location_id')->constrained('locations')->onDelete('restrict');
            $table->foreignId('season_id')->constrained('seasons')->onDelete('restrict');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('restrict');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
