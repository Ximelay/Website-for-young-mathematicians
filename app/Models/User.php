<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'email',
        'password',
        'phone',
        'municipality_id',
        'locality',
        'organization_id',
        'grade',
        'team_id',
        'position',
        'is_active',
        'marked_for_deletion',
        'deletion_reason',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'marked_for_deletion' => 'boolean',
            'grade' => 'integer',
        ];
    }

    /**
     * Роли пользователя
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user')
            ->withTimestamps();
    }

    /**
     * Муниципалитет пользователя
     */
    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * Организация пользователя
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Команда пользователя (для участников)
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Команды, которыми руководит пользователь (для наставников)
     */
    public function mentorTeams(): HasMany
    {
        return $this->hasMany(Team::class, 'mentor_id');
    }

    /**
     * Согласие на обработку персональных данных
     */
    public function consentDocument(): HasOne
    {
        return $this->hasOne(ConsentDocument::class);
    }

    /**
     * Новости, созданные пользователем
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'author_id');
    }

    /**
     * События, созданные пользователем
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    /**
     * Материалы, загруженные пользователем
     */
    public function materials(): HasMany
    {
        return $this->hasMany(Material::class, 'uploaded_by');
    }

    /**
     * Отзывы, написанные пользователем
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'author_id');
    }

    /**
     * Проверка наличия роли
     */
    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    /**
     * Проверка наличия любой из ролей
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    /**
     * Проверка наличия разрешения
     */
    public function hasPermission(string $actionName): bool
    {
        return $this->roles()
            ->whereHas('permissions', function ($query) use ($actionName) {
                $query->where('action_name', $actionName);
            })
            ->exists();
    }

    /**
     * Получить полное имя пользователя
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->last_name} {$this->first_name} {$this->middle_name}");
    }

    /**
     * Scope для активных пользователей
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('marked_for_deletion', false);
    }

    /**
     * Scope для пользователей с определенной ролью
     */
    public function scopeWithRole($query, string $roleName)
    {
        return $query->whereHas('roles', function ($q) use ($roleName) {
            $q->where('name', $roleName);
        });
    }

    /**
     * Scope для участников
     */
    public function scopeParticipants($query)
    {
        return $query->withRole('participant');
    }

    /**
     * Scope для наставников
     */
    public function scopeMentors($query)
    {
        return $query->withRole('mentor');
    }

    /**
     * Scope для координаторов
     */
    public function scopeCoordinators($query)
    {
        return $query->withRole('municipal_coordinator');
    }

    /**
     * Scope для организаторов
     */
    public function scopeOrganizers($query)
    {
        return $query->withRole('organizer');
    }
}
