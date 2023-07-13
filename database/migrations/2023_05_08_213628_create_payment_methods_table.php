<?php

use App\Entities\PaymentMethodEntities;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon');
            $table->string('code');
            $table->string('type')->default(PaymentMethodEntities::PAYMENT_METHOD_TYPE_BANK);
            $table->string('status')->default(PaymentMethodEntities::PAYMENT_METHOD_STATUS_ACTIVE);
            $table->string('description')->nullable();
            $table->decimal('fee', 20, 0)->nullable();
            $table->string('account_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
