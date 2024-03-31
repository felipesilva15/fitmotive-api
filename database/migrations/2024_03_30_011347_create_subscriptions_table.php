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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained();
            $table->foreignId('plan_id')->constrained();
            $table->string('bank_gateway_id', 60)->nullable();
            $table->decimal('amount', 6, 2);
            $table->boolean('pro_rata')->default(false);
            $table->enum('payment_status', ['PAID', 'WAITING', 'CANCELED', 'DECLINED', 'IN_ANALYSIS', 'AUTHORIZED']);
            $table->boolean('inactive')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
