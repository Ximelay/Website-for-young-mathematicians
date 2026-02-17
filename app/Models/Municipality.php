<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipality extends Model
{
    protected $fillable = [
        'name',
        'region',
    ];

    /**
     * Организации в этом муниципалитете
     */
    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }

    /**
     * Команды из этого муниципалитета
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    /**
     * Пользователи из этого муниципалитета
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Муниципальные этапы
     */
    public function municipalStages(): HasMany
    {
        return $this->hasMany(MunicipalStage::class);
    }

    /**
     * События связанные с муниципалитетом
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
