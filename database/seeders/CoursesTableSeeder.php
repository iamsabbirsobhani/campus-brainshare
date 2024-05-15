<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = ['CSE246', 'CSE303', 'CSE479', 'CSE487', 'CSE366', 'CSE103', 'CSE106', 'CSE302', 'CSE345'];

        foreach ($courses as $courseName) {
            Course::create(['name' => $courseName]);
        }
    }
}
