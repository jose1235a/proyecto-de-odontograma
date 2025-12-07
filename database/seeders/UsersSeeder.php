<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Alexander Pingo', 'email' => 'pingo@gmail.com'],
            ['name' => 'Manuela Pinga', 'email' => 'pinga@gmail.com'],
            ['name' => 'Joel Jimenez', 'email' => 'joel@gmail.com'],
            ['name' => 'Yunikua', 'email' => 'kiara@gmail.com'],
            ['name' => 'Tayron Misari', 'email' => 'misari@gmail.com'],
            ['name' => 'Yasumy Pastor', 'email' => 'yasumy@gmail.com'],
            ['name' => 'Nerio Vasquez', 'email' => 'nerio@gmail.com'],
            ['name' => 'Jhon Pastor', 'email' => 'jhon@gmail.com'],
            ['name' => 'Jose de los Bayardigans', 'email' => 'jose@gmail.com'],
            ['name' => 'Boris el Varon', 'email' => 'boris@gmail.com'],
            ['name' => 'Jefferson el Delegado', 'email' => 'jefferson@gmail.com'],
            ['name' => 'Pampis de Tiktok', 'email' => 'fabio@gmail.com'],
        ];

        $roleMap = [
            'pingo@gmail.com' => 'super',
            'pinga@gmail.com' => 'admin',
            'joel@gmail.com'  => 'language_manager',
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'       => $data['name'],
                    'password'   => Hash::make('123456'),
                    'slug'       => Str::random(22),
                    'tenant_id'  => 1,
                    'country_id' => 1,
                    'locale_id'  => 1,
                    'created_by' => 1,
                    'is_active'  => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $role = $roleMap[$data['email']] ?? 'user';
            $user->syncRoles($role);
        }
    }
}
