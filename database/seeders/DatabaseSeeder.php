<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ClassesSeeder::class,
            Permission::class,
        ]);

        // \App\Models\User::factory(10)->create();

        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'nick_name' => 'super-admin',
            'phone' => '0001112222',
            'referral' => Str::random(10),
            'date_of_birth' => '1990-08-20',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'nick_name' => 'admin',
            'phone' => '111222333',
            'referral' => Str::random(10),
            'date_of_birth' => '1990-08-20',
        ]);
        $moderate = User::factory()->create([
            'name' => 'Moderate',
            'email' => 'moderate@gmail.com',
            'nick_name' => 'moderator',
            'phone' => '222333444',
            'referral' => Str::random(10),
            'date_of_birth' => '1990-08-20',
        ]);
        $superAdmin->assignRole(Role::create(['name' => 'Super Admin']));
        $admin->assignRole(Role::create(['name' => 'Admin']));
        $moderate->assignRole(Role::create(['name' => 'Moderate']));

//todo  Seed roles
    }
}
