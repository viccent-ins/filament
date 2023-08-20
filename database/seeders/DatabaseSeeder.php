<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ClassesSeeder::class
        ]);

        // \App\Models\User::factory(10)->create();


        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
        ]);

        $admin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
        ]);
        $superAdmin->assignRole(Role::create(['name' => 'Super Admin']));
        $admin->assignRole(Role::create(['name' => 'Admin']));

    }
}
