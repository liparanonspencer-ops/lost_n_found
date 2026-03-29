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
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'test',
            'last_name' => 'test',
            'address' => '123st.anytown city',
            'profile_photo'=> null,
            'email' => 'test@example.com',
            'password' => 'password',
            'role' => 'user'
        ]);

          User::factory()->create([
            'first_name' => 'Spencer',
            'last_name' => 'Dizon',
            'address' => '123st. anytown city',
            'email' => 'admin@example.com',
            'profile_photo' => null,
            'password' => 'password',
            'role' => 'admin'
        ]);
    }
}
