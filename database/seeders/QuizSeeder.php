<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createQuizzes($count = 10);// 100 * 3 * 3
    }
    public function createQuizzes($count)
    {
        Quiz::factory()
            ->count($count)
            ->hasQuestions(3)
            ->create();
    }
}
