<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Permission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         \App\Models\Permission::create(['name' => 'View']);
         \App\Models\Permission::create(['name' => 'Create']);
         \App\Models\Permission::create(['name' => 'Update']);
         \App\Models\Permission::create(['name' => 'Delete']);
    }
}
