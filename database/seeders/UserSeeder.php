<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'John Doe',
            'image' => 'default.jpg',
            'email' => 'amar99995555amar@gmail.com',
            'password' => Hash::make('1234566789'),
            'type_user' => 'service_provider',
        ]);
    }
}
