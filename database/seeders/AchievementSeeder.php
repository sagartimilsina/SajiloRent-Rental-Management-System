<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Achievement::insert([
            ['title' => 'Happy Customers', 'count' => 1000],
            ['title' => 'Projects Completed', 'count' => 500],
            ['title' => 'Team Members', 'count' => 200],
            ['title' => 'Awards Won', 'count' => 50],
        ]);
    }
}
