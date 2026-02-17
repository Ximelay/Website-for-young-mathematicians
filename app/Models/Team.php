<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    protected $fillable = [
        'name',
        'organization_id',
        'municipality_id',
        'mentor_id',
        'grade',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Организация команды
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Муниципалитет команды
     */
    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * Наставник команды
     */
    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    /**
     * Участники команды
     */
    public function members(): HasMany
    {
        return $this->hasMany(User::class, 'team_id');
    }

    /**
     * Муниципальные этапы, в которых участвует команда
     */
    public function municipalStages(): BelongsToMany
    {
        return $this->belongsToMany(MunicipalStage::class, 'municipal_stage_teams')
            ->withPivot('score', 'rank', 'qualified_for_regional')
            ->withTimestamps();
    }

    /**
     * Региональные этапы, в которых участвует команда
     */
    public function regionalStages(): BelongsToMany
    {
        return $this->belongsToMany(RegionalStage::class, 'regional_stage_teams')
            ->using(RegionalStageTeam::class)
            ->withPivot('score', 'rank')
            ->withTimestamps();
    }
}
