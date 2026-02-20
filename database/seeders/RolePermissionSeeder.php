<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Роли
        $roles = [
            ['name' => 'organizer',             'guard_name' => 'web'],
            ['name' => 'municipal_coordinator', 'guard_name' => 'web'],
            ['name' => 'mentor',                'guard_name' => 'web'],
            ['name' => 'participant',           'guard_name' => 'web'],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(['name' => $roleData['name']], $roleData);
        }

        // Разрешения
        $permissions = [
            ['action_name' => 'manage_users',     'description' => 'Управление пользователями'],
            ['action_name' => 'manage_events',    'description' => 'Управление событиями'],
            ['action_name' => 'manage_news',      'description' => 'Управление новостями'],
            ['action_name' => 'manage_materials', 'description' => 'Управление материалами'],
            ['action_name' => 'manage_teams',     'description' => 'Управление командами'],
            ['action_name' => 'manage_stages',    'description' => 'Управление этапами'],
            ['action_name' => 'view_results',     'description' => 'Просмотр результатов'],
            ['action_name' => 'upload_materials', 'description' => 'Загрузка материалов'],
            ['action_name' => 'view_materials',   'description' => 'Просмотр материалов'],
        ];

        foreach ($permissions as $permData) {
            Permission::firstOrCreate(['action_name' => $permData['action_name']], $permData);
        }

        // Привязка разрешений к ролям
        $organizer = Role::where('name', 'organizer')->first();
        $organizer->permissions()->sync(Permission::pluck('id')); // Все права

        $coordinator = Role::where('name', 'municipal_coordinator')->first();
        $coordinator->permissions()->sync(
            Permission::whereIn('action_name', [
                'manage_events',
                'manage_teams',
                'manage_stages',
                'view_results',
                'upload_materials',
                'view_materials',
            ])->pluck('id')
        );

        $mentor = Role::where('name', 'mentor')->first();
        $mentor->permissions()->sync(
            Permission::whereIn('action_name', [
                'manage_teams',
                'view_results',
                'upload_materials',
                'view_materials',
            ])->pluck('id')
        );

        $participant = Role::where('name', 'participant')->first();
        $participant->permissions()->sync(
            Permission::whereIn('action_name', [
                'view_results',
                'view_materials',
            ])->pluck('id')
        );
    }
}
