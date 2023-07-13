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
        Schema::create('sales', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->dateTime('sales_date');
            $table->dateTime('confirm_date')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->foreignId('sales_status_id')->constrained('sales_status');
            $table->tinyInteger('type');
            $table->decimal('total_price', 20, 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
