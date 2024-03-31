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
        Schema::create('adresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('name', 40);
            $table->string('postal_code', 8);
            $table->string('street', 80);
            $table->string('locality', 40);
            $table->string('city', 60);
            $table->string('region', 40);
            $table->string('region_code', 2);
            $table->string('number', 6);
            $table->string('complement', 120)->nullable();
            $table->boolean('main');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adresses');
    }
};
