<?php

namespace Database\Seeders;

use App\Models\GradeLevel;
use Illuminate\Database\Seeder;

class GradeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            // grade 1
            $grade = new GradeLevel;
            $grade = $grade->create([
                'grade_level_name' => 'Grade 1',
            ]);
            // grade 2
            $grade = new GradeLevel;
            $grade = $grade->create([
                'grade_level_name' => 'Grade 2',
            ]);
            // grade 3
            $grade = new GradeLevel;
            $grade = $grade->create([
                'grade_level_name' => 'Grade 3',
            ]);
        }
    }
}
