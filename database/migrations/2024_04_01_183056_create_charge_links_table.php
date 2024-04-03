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
        Schema::create('charge_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('charge_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->enum('reference', ['QRCODE_PIX', 'BOLETO', 'PAYMENT']);
            $table->string('uri', 512);
            $table->enum('response_type', ['PNG', 'PDF', 'TEXT', 'JSON', 'XML']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charge_links');
    }
};
