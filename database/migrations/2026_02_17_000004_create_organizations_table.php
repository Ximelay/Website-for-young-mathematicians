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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название организации
            $table->foreignId('municipality_id')->constrained()->cascadeOnDelete(); // Муниципальное образование
            $table->string('locality')->nullable(); // Населенный пункт
            $table->string('address')->nullable(); // Адрес
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
