<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \DB::unprepared(file_get_contents(storage_path('backups/countries.sql')));
        \DB::unprepared(file_get_contents(storage_path('backups/states.sql')));
        \DB::unprepared(file_get_contents(storage_path('backups/cities.sql')));

        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
