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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->enum('type', ['CREDIT_CARD', 'DEBIT_CARD', 'PIX', 'BOLETO']);
            $table->string('card_number', 21)->nullable();
            $table->string('network_token', 40)->nullable();
            $table->char('exp_month', 2)->nullable();
            $table->char('exp_year', 4)->nullable();
            $table->char('security_code', 3)->nullable();
            $table->boolean('main');
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
