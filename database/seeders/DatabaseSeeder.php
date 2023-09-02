<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Carbon\Carbon;
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
            'username' => 'superadmin',
            'phone' => '0001112222',
            'user_address' => '0001112222',
            'email' => 'superadmin@gmail.com',
            'user_level' => 'level1',
            'login_time' => Carbon::now()->toDateString(),
            'date_of_birth' => '1990-08-20',
        ]);

        $admin = User::factory()->create([
            'username' => 'admin',
            'phone' => '111222333',
            'user_address' => '111222333',
            'email' => 'admin@gmail.com',
            'user_level' => 'level2',
            'login_time' => Carbon::now()->toDateString(),
            'date_of_birth' => '1990-08-20',
        ]);
        $moderator = User::factory()->create([
            'username' => 'moderator',
            'phone' => '222333444',
            'user_address' => '111222333',
            'email' => 'moderate@gmail.com',
            'user_level' => 'level3',
            'login_time' => Carbon::now()->toDateString(),
            'date_of_birth' => '1990-08-20',
        ]);
        $superAdmin->assignRole(Role::create(['name' => 'Super Admin']));
        $admin->assignRole(Role::create(['name' => 'Admin']));
        $moderator->assignRole(Role::create(['name' => 'Moderator']));

//todo  Seed roles
    }
}
