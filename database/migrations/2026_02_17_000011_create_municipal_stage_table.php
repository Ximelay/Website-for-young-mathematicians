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
        Schema::create('municipal_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('municipality_id')->constrained()->cascadeOnDelete();
            $table->dateTime('event_date'); // Дата проведения
            $table->time('event_time')->nullable(); // Время проведения
            $table->string('venue'); // Место проведения
            $table->string('venue_address')->nullable(); // Адрес места проведения
            $table->text('contact_info')->nullable(); // Контактные данные
            $table->enum('status', ['planned', 'ongoing', 'completed'])->default('planned'); // Статус
            $table->text('results')->nullable(); // Итоги (может быть JSON или текст)
            $table->timestamps();
        });

        // Таблица связи команд и муниципальных этапов
        Schema::create('municipal_stage_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('municipal_stage_id')->constrained('municipal_stages')->cascadeOnDelete();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->integer('score')->nullable(); // Баллы команды
            $table->integer('rank')->nullable(); // Место команды
            $table->boolean('qualified_for_regional')->default(false); // Прошла в региональный этап
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipal_stage_teams');
        Schema::dropIfExists('municipal_stages');
    }
};
