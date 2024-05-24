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
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('charge_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('bank_gateway_id', 60)->nullable();
            $table->string('image_uri', 512);
            $table->string('text', 1024);
            $table->decimal('amount', 6, 2);
            $table->date('expiration_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_codes');
    }
};
