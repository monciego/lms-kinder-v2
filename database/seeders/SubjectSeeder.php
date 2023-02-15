<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            /*=== GRADE 1 ===*/
            // math
            $code = Str::random(10);
            $subject = new Subject;
            $subject = $subject->create([
                'subject_name' => 'math',
                'subject_code' => $code,
                'grade_level_id' => '1',
            ]);
            
            // science
            $code = Str::random(10);
            $subject = new Subject;
            $subject = $subject->create([
                'subject_name' => 'science',
                'subject_code' => $code,
                'grade_level_id' => '1',
            ]);
            
            // filipino
            $code = Str::random(10);
            $subject = new Subject;
            $subject = $subject->create([
                'subject_name' => 'filipino',
                'subject_code' => $code,
                'grade_level_id' => '1',
            ]);
            
            // filipino
            $code = Str::random(10);
            $subject = new Subject;
            $subject = $subject->create([
                'subject_name' => 'english',
                'subject_code' => $code,
                'grade_level_id' => '1',
            ]);
            
            // mapeh
            $code = Str::random(10);
            $subject = new Subject;
            $subject = $subject->create([
                'subject_name' => 'mapeh',
                'subject_code' => $code,
                'grade_level_id' => '1',
            ]);
            
            // mtb
            $code = Str::random(10);
            $subject = new Subject;
            $subject = $subject->create([
                'subject_name' => 'mtb',
                'subject_code' => $code,
                'grade_level_id' => '1',
            ]);
            
            
            /*=== GRADE 2 ===*/
            // math
            $code = Str::random(10);
            $subject = new Subject;
            $subject = $subject->create([
                'subject_name' => 'math',
                'subject_code' => $code,
                'grade_level_id' => '2',
            ]);
            
            // science
            $code = Str::random(10);
            $subject = new Subject;
            $subject = $subject->create([
                'subject_name' => 'science',
                'subject_code' => $code,
                'grade_level_id' => '2',
            ]);
            
            // filipino
            $code = Str::random(10);
            $subject = new Subject;
            $subject = $subject->create([
                'subject_name' => 'filipino',
                'subject_code' => $code,
                'grade_level_id' => '2',
            ]);
            
            // filipino
            $code = Str::random(10);
            $subject = new Subject;
            $subject = $subject->create([
                'subject_name' => 'english',
                'subject_code' => $code,
                'grade_level_id' => '2',
            ]);
            
            // mapeh
            $code = Str::random(10);
            $subject = new Subject;
            $subject = $subject->create([
                'subject_name' => 'mapeh',
                'subject_code' => $code,
                'grade_level_id' => '2',
            ]);
            
            // mtb
            $code = Str::random(10);
            $subject = new Subject;
            $subject = $subject->create([
                'subject_name' => 'mtb',
                'subject_code' => $code,
                'grade_level_id' => '2',
            ]);
            
            /*=== GRADE 3 ===*/
            // math
            $code = Str::random(10);
            $subject = new Subject;
            $subject = $subject->create([
                'subject_name' => 'math',
                'subject_code' => $code,
                'grade_level_id' => '3',
            ]);
            
            // science
            $code = Str::random(10);
            $subject = new Subject;
            $subject = $subject->create([
                'subject_name' => 'science',
                'subject_code' => $code,
                'grade_level_id' => '3',
            ]);
            
            // filipino
            $code = Str::random(10);
            $subject = new Subject;
            $subject = $subject->create([
                'subject_name' => 'filipino',
                'subject_code' => $code,
                'grade_level_id' => '3',
            ]);
            
            // filipino
            $code = Str::random(10);
            $subject = new Subject;
            $subject = $subject->create([
                'subject_name' => 'english',
                'subject_code' => $code,
                'grade_level_id' => '3',
            ]);
            
            // mapeh
            $code = Str::random(10);
            $subject = new Subject;
            $subject = $subject->create([
                'subject_name' => 'mapeh',
                'subject_code' => $code,
                'grade_level_id' => '3',
            ]);
            
            // mtb
            $code = Str::random(10);
            $subject = new Subject;
            $subject = $subject->create([
                'subject_name' => 'mtb',
                'subject_code' => $code,
                'grade_level_id' => '3',
            ]);
        }
    }
}
