<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ["email" => "admin@email.com"],
            [
                "name"=> "admin",
                "password"=> Hash::make("password"),
                "is_admin"=> true,
            ]
        );
    }
}
