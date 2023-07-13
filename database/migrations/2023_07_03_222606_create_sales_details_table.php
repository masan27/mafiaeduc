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
        Schema::create('sales_details', function (Blueprint $table) {
            $table->id();
            $table->string('sales_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('material_id')->nullable();
            $table->unsignedBigInteger('private_classes_id')->nullable();
            $table->unsignedBigInteger('group_classes_id')->nullable();
            $table->decimal('sub_total', 20, 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_details');
    }
};
