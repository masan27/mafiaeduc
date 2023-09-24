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
        Schema::create('reviews', function (Blueprint $table) {
            $table->string('sales_id');
            $table->foreign('sales_id')->references('id')->on('sales')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('mentor_id')->nullable()->constrained('mentors');
            $table->foreignId('private_classes_id')->nullable()->constrained('private_classes');
            $table->foreignId('group_classes_id')->nullable()->constrained('group_classes');
            $table->foreignId('material_id')->nullable()->constrained('materials');
            $table->tinyInteger('type');
            $table->decimal('rating', 2, 1);
            $table->text('comment');
            $table->primary(['sales_id', 'user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
