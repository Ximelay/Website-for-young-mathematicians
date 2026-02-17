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
        Schema::create('consent_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Пользователь
            $table->string('file_path'); // Путь к файлу согласия
            $table->string('file_name'); // Оригинальное имя файла
            $table->timestamp('uploaded_at'); // Когда загружено
            $table->boolean('is_verified')->default(false); // Проверено администратором
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consent_documents');
    }
};
