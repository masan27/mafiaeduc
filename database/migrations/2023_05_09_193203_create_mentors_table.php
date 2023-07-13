<?php

use App\Entities\MentorEntities;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mentors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('grade_id')->constrained('grades')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('learning_method_id')->constrained('learning_methods')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('full_name');
            $table->string('photo');
            $table->string('certificate');
            $table->string('identity_card');
            $table->string('cv');
            $table->string('teaching_video');
            $table->string('phone', 16);
            $table->decimal('salary', 20, 0);
            $table->boolean('status')->default(MentorEntities::MENTOR_STATUS_PENDING_APPROVAL);
            $table->string('linkedin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentors');
    }
};
