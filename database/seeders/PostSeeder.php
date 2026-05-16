<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        if ($users->isEmpty()) {
            $users = User::factory(5)->create();
        }

        Post::factory(20)->create([
            'author_id' => function () use ($users) {
                return $users->random()->id;
            },
        ]);
    }
}
