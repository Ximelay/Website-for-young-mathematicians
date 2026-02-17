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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Заголовок новости
            $table->text('content'); // Содержание
            $table->string('slug')->unique(); // URL-дружественный идентификатор
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete(); // Автор (организатор)
            $table->boolean('is_published')->default(false); // Опубликовано
            $table->timestamp('published_at')->nullable(); // Дата публикации
            $table->string('image_path')->nullable(); // Путь к изображению
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
