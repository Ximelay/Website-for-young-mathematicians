<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Municipality;
use App\Models\Organization; // ✅ Добавили импорт
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1️⃣ Роли и разрешения
        $this->call(RolePermissionSeeder::class);

        // 2️⃣ Создаём один муниципалитет
        $municipality = Municipality::firstOrCreate(
            ['name' => 'Городской округ Иркутск']
        );
        $this->command->info('✅ Муниципалитет создан');

        // 2.1️⃣ ✅ Создаём тестовые организации
        $organizations = [
            ['name' => 'МБОУ СОШ №1', 'municipality_id' => $municipality->id],
            ['name' => 'МБОУ СОШ №2', 'municipality_id' => $municipality->id],
            ['name' => 'МБОУ Гимназия №1', 'municipality_id' => $municipality->id],
            ['name' => 'МБОУ Лицей №1', 'municipality_id' => $municipality->id],
        ];

        foreach ($organizations as $org) {
            Organization::firstOrCreate(
                ['name' => $org['name']],
                $org
            );
        }
        $this->command->info('✅ Организации созданы');

        // 3️⃣ Тестовый организатор
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
        if ($organizerRole && !$organizer->roles()->where('name', 'organizer')->exists()) {
            $organizer->roles()->attach($organizerRole->id);
        }
        $this->command->info('✅ Организатор создан: admin@tyum.ru');

        // 4️⃣ Тестовый координатор
        $coordinatorRole = Role::where('name', 'municipal_coordinator')->first();

        if ($coordinatorRole) {
            $coordinator = User::firstOrCreate(
                ['email' => 'coordinator@tyum.ru'],
                [
                    'first_name'      => 'Анна',
                    'last_name'       => 'Координаторова',
                    'middle_name'     => 'Петровна',
                    'email'           => 'coordinator@tyum.ru',
                    'password'        => Hash::make('password'),
                    'phone'           => '+7 (999) 111-22-33',
                    'municipality_id' => $municipality->id,
                    'position'        => 'Методист',
                    'is_active'       => true,
                ]
            );

            if (!$coordinator->roles()->where('name', 'municipal_coordinator')->exists()) {
                $coordinator->roles()->attach($coordinatorRole->id);
            }
            $this->command->info('✅ Координатор создан: coordinator@tyum.ru');
        }

        // 5️⃣ 🔥 ТЕСТОВЫЙ НАСТАВНИК
        $mentorRole = Role::where('name', 'mentor')->first();

        if ($mentorRole) {
            $mentor = User::firstOrCreate(
                ['email' => 'mentor@tyum.ru'],
                [
                    'first_name'      => 'Иван',
                    'last_name'       => 'Наставников',
                    'middle_name'     => 'Петрович',
                    'email'           => 'mentor@tyum.ru',
                    'password'        => Hash::make('password'),
                    'phone'           => '+7 (999) 222-33-44',
                    'municipality_id' => $municipality->id,
                    'position'        => 'Учитель математики',
                    'is_active'       => true,
                ]
            );

            if (!$mentor->roles()->where('name', 'mentor')->exists()) {
                $mentor->roles()->attach($mentorRole->id);
            }
            $this->command->info('✅ Наставник создан: mentor@tyum.ru');
        }

        // 6️⃣ ТЕСТОВЫЙ УЧАСТНИК (без команды)
        $participantRole = Role::where('name', 'participant')->first();

        if ($participantRole) {
            User::firstOrCreate(
                ['email' => 'participant@tyum.ru'],
                [
                    'first_name'      => 'Алексей',
                    'last_name'       => 'Участников',
                    'middle_name'     => 'Иванович',
                    'email'           => 'participant@tyum.ru',
                    'password'        => Hash::make('password'),
                    'phone'           => '+7 (999) 333-44-55',
                    'municipality_id' => $municipality->id,
                    'locality'        => 'г. Иркутск',
                    'grade'           => 8,
                    'team_id'         => null,
                    'is_active'       => true,
                ]
            )->roles()->attach($participantRole->id);

            $this->command->info('✅ Участник создан: participant@tyum.ru');
        }

        $this->command->info('🎉 Все сидеры выполнены!');
        $this->command->warn('📝 Данные для входа:');
        $this->command->warn('   🎯 Организатор:   admin@tyum.ru / password');
        $this->command->warn('   🏛️ Координатор:   coordinator@tyum.ru / password');
        $this->command->warn('   👨‍🏫 Наставник:     mentor@tyum.ru / password');
        $this->command->warn('   🎓 Участник:      participant@tyum.ru / password');
        $this->command->warn('');
        $this->command->warn('📚 Организации:');
        $this->command->warn('   • МБОУ СОШ №1');
        $this->command->warn('   • МБОУ СОШ №2');
        $this->command->warn('   • МБОУ Гимназия №1');
        $this->command->warn('   • МБОУ Лицей №1');
    }
}
