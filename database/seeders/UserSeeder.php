<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role_id'=>1
        ]);


        //students
        User::factory(10)->create(['role_id'=>2]);




    }
}
