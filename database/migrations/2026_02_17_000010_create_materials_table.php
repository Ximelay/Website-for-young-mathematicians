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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Название материала
            $table->text('description')->nullable(); // Описание
            $table->enum('type', ['task', 'solution', 'video', 'other']); // Тип материала
            $table->integer('year')->nullable(); // Год (для заданий прошлых лет)
            $table->string('file_path')->nullable(); // Путь к файлу
            $table->string('file_type')->nullable();  // Расширение файла (pdf, docx...)
            $table->unsignedBigInteger('file_size')->nullable(); // Размер файла в байтах
            $table->string('video_url')->nullable(); // Ссылка на видео
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete(); // Кто загрузил
            $table->boolean('is_published')->default(false); // Опубликовано
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
