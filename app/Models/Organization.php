<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'municipality_id',
        'locality',
        'address',
    ];

    /**
     * Муниципалитет организации
     */
    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * Команды из этой организации
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    /**
     * Пользователи (участники, наставники) из этой организации
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
