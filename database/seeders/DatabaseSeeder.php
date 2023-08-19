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


         $user1 = User::factory()->create([
             'name' => 'admin',
             'email' => 'admin@gmail.com',
         ]);

         User::factory()->create([
            'name' => 'user',
            'email' => 'user@gmail.com',
        ]);
        $role = Role::create(['name' => 'admin']);
        $user1->assignRole($role);

    }
}
