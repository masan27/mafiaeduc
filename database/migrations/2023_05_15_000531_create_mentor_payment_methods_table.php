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
        Schema::create('mentor_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('mentors')->cascadeOnDelete();
            $table->foreignId('payment_method_id')->constrained('payment_methods')->cascadeOnDelete();
            $table->string('account_number');
            $table->string('account_name');
            $table->string('bank_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentor_payment_methods');
    }
};
