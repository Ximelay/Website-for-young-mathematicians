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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');

            // Дополнительные поля для участников
            $table->foreignId('municipality_id')->nullable()->constrained()->nullOnDelete();
            $table->string('locality')->nullable(); // Населенный пункт
            $table->foreignId('organization_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('grade')->nullable(); // Класс (для участников)
            $table->unsignedBigInteger('team_id')->nullable(); // Команда (для участников) - внешний ключ добавим позже

            // Для координаторов и организаторов
            $table->string('position')->nullable(); // Должность

            // Статус и отметки
            $table->boolean('is_active')->default(true);
            $table->boolean('marked_for_deletion')->default(false); // Помечен на удаление
            $table->text('deletion_reason')->nullable(); // Причина удаления

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('users');
    }
};
