<?php

namespace Database\Seeders;

use App\Models\{Question, User};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(1)->create();
        Question::factory()->count(200)->create();
    }
}
