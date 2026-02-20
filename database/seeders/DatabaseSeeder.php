<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Роли и разрешения
        $this->call(RolePermissionSeeder::class);

        // Тестовый организатор
        $organizer = User::firstOrCreate(
            ['email' => 'admin@tyum.ru'],
            [
                'first_name'  => 'Администратор',
                'last_name'   => 'Системный',
                'middle_name' => null,
                'email'       => 'admin@tyum.ru',
                'password'    => Hash::make('password'),
                'phone'       => '+7 (000) 000-00-00',
                'is_active'   => true,
            ]
        );

        $organizerRole = Role::where('name', 'organizer')->first();
        if ($organizerRole && ! $organizer->roles()->where('name', 'organizer')->exists()) {
            $organizer->roles()->attach($organizerRole->id);
        }
    }
}
