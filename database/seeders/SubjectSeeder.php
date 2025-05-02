<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\Student;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        $subjects = ['Math', 'Science', 'English', 'History', 'Geography'];

        foreach (Student::take(25)->get() as $student) {
            foreach ($subjects as $subjectName) {
                Subject::create([
                    'student_id' => $student->id,
                    'name' => $subjectName,
                    'current_term_mark' => rand(60, 100),
                    'previous_term_mark' => rand(50, 95),
                ]);
            }
        }
    }
}
