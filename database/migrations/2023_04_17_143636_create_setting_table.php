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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->integer('number_of_question_per_student');
            $table->unsignedInteger('exam_time');
            $table->integer('marks_per_question');
            $table->integer('passing_mark');
            $table->boolean('is_negative_marking')->default(false);
            $table->integer('negative_marking_per_question')->nullable();
            $table->boolean('an_option_right_marking')->default(false);
            $table->boolean('active')->default(false);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
