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
            Permission::class,
        ]);

        // \App\Models\User::factory(10)->create();

        $superAdmin = User::factory()->create([
            'username' => 'Super Admin',
            'mobile' => '0001112222',
            'email' => 'superadmin@gmail.com',
            'nick_name' => 'super-admin',
            'referral' => Str::random(10),
            'date_of_birth' => '1990-08-20',
        ]);

        $admin = User::factory()->create([
            'username' => 'Admin',
            'mobile' => '111222333',
            'email' => 'admin@gmail.com',
            'nick_name' => 'admin',
            'referral' => Str::random(10),
            'date_of_birth' => '1990-08-20',
        ]);
        $moderator = User::factory()->create([
            'username' => 'Moderator',
            'mobile' => '222333444',
            'email' => 'moderate@gmail.com',
            'nick_name' => 'moderator',
            'referral' => Str::random(10),
            'date_of_birth' => '1990-08-20',
        ]);
        $superAdmin->assignRole(Role::create(['name' => 'Super Admin']));
        $admin->assignRole(Role::create(['name' => 'Admin']));
        $moderator->assignRole(Role::create(['name' => 'Moderator']));

//todo  Seed roles
    }
}
