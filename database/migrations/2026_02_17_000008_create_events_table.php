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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Название события
            $table->text('description')->nullable(); // Описание
            $table->dateTime('start_date'); // Дата и время начала
            $table->dateTime('end_date')->nullable(); // Дата и время окончания
            $table->string('location')->nullable(); // Место проведения
            $table->enum('type', ['municipal_stage', 'regional_stage', 'meeting', 'deadline', 'other']); // Тип события
            $table->foreignId('municipality_id')->nullable()->constrained()->nullOnDelete(); // Связь с муниципалитетом (если применимо)
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete(); // Кто создал
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
