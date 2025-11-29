<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Admin
        \App\Models\User::factory()->create([
            'name' => 'Admin Sistem',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // 2. Buat Teacher
        \App\Models\User::factory()->create([
            'name' => 'Pak Budi Guru',
            'email' => 'teacher@school.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
        ]);

        // 3. Buat Student
        \App\Models\User::factory()->create([
            'name' => 'Andi Siswa',
            'email' => 'student@school.com',
            'password' => bcrypt('password'),
            'role' => 'student',
        ]);
        
        // 4. Buat Kategori Dummy
        \App\Models\Category::create(['name' => 'Web Programming', 'slug' => 'web-prog']);
        \App\Models\Category::create(['name' => 'Desain Grafis', 'slug' => 'desain']);
    }
}
