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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->text('content'); // Текст отзыва
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete(); // Автор отзыва
            $table->morphs('reviewable'); // Полиморфная связь (может быть для муниципального или регионального этапа)
            $table->boolean('is_approved')->default(false); // Одобрен модератором
            $table->boolean('is_published')->default(false); // Опубликован
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
