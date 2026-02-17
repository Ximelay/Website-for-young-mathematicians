<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = [
        'name',
        'guard_name',
    ];

    protected $attributes = [
        'guard_name' => 'web',
    ];

    /**
     * Пользователи с этой ролью
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user')
            ->withTimestamps();
    }

    /**
     * Разрешения этой роли
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')
            ->withTimestamps();
    }

    /**
     * Проверка наличия разрешения
     */
    public function hasPermission(string $actionName): bool
    {
        return $this->permissions()->where('action_name', $actionName)->exists();
    }
}
