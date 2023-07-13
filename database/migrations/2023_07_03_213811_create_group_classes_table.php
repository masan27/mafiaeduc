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
        Schema::create('group_classes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('grade_id')->constrained('grades')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('learning_method_id')->constrained('learning_methods')->cascadeOnDelete();
            $table->string('description');
            $table->string('additional_info')->nullable();
            $table->decimal('price', 20);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_classes');
    }
};
