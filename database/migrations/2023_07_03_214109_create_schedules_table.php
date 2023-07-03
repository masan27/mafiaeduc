<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_method_id')->constrained('learning_methods');
            $table->foreignId('private_classes_id')->nullable()->constrained('private_classes');
            $table->foreignId('group_classes_id')->nullable()->constrained('group_classes');
            $table->foreignId('mentor_id')->constrained('mentors');
            $table->foreignId('grade_id')->constrained('grades');
            $table->foreignId('subject_id')->constrained('subjects');
            $table->string('meeting_link')->nullable();
            $table->string('meeting_platform')->nullable();
            $table->string('address')->nullable();
            $table->date('date');
            $table->string('time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
