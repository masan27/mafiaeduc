<?php

use App\Entities\MentorPaymentEntities;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mentor_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_payment_method_id')->constrained('mentor_payment_methods')->cascadeOnDelete();
            $table->string('payment_id');
            $table->string('payment_amount');
            $table->string('payment_proof')->nullable();
            $table->boolean('status')->default(MentorPaymentEntities::PAYMENT_STATUS_PENDING);
            $table->string('feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentor_payments');
    }
};
