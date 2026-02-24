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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название команды
            $table->text('description')->nullable(); // Описание команды
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete(); // Образовательная организация
            $table->foreignId('municipality_id')->constrained()->cascadeOnDelete(); // Муниципальное образование
            $table->foreignId('mentor_id')->nullable()->constrained('users')->nullOnDelete(); // Наставник
            $table->integer('grade')->nullable(); // Класс (может быть общий для команды)
            $table->boolean('is_active')->default(true); // Активна ли команда
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
