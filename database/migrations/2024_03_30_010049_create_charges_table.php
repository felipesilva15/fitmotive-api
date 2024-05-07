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
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('patient_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('financial_transaction_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('bank_gateway_id', 60)->nullable();
            $table->string('description', 80)->nullable();
            $table->enum('payment_method', ['CREDIT_CARD', 'DEBIT_CARD', 'PIX', 'BOLETO']);
            $table->date('due_date');
            $table->decimal('amount', 6, 2);
            $table->enum('payment_status', ['PAID', 'WAITING', 'CANCELED', 'DECLINED', 'IN_ANALYSIS', 'AUTHORIZED']);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
