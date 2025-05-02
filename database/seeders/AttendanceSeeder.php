<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        $statuses = ['present', 'absent', 'late'];

        $students = Student::all();
        $startDate = Carbon::now()->subDays(30);

        foreach ($students as $student) {
            for ($i = 0; $i < 30; $i++) {
                Attendance::create([
                    'student_id' => $student->id,
                    'date' => $startDate->copy()->addDays($i)->format('Y-m-d'),
                    'status' => $statuses[array_rand($statuses)],
                ]);
            }
        }
    }
}
