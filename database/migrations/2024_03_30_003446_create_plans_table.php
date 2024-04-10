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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40);
            $table->text('description');
            $table->decimal('price', 6, 2);
            $table->integer('trial_days')->nullable();
            $table->enum('biling_interval', ['DAY', 'MONTH', 'YEAR']);
            $table->string('bank_gateway_id', 60)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
