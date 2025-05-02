<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{    
    public function getAttendanceStats($studentId)
    {
        $totalDays = Attendance::where('student_id', $studentId)->count();
        $present = Attendance::where('student_id', $studentId)->where('status', 'present')->count();
        $absent = Attendance::where('student_id', $studentId)->where('status', 'absent')->count();
        $late = Attendance::where('student_id', $studentId)->where('status', 'late')->count();
    
        if ($totalDays === 0) {
            return response()->json([
                'present' => 0,
                'absent' => 0,
                'late' => 0
            ]);
        }
    
        return response()->json([
            'present' => round(($present / $totalDays) * 100),
            'absent' => round(($absent / $totalDays) * 100),
            'late' => round(($late / $totalDays) * 100),
        ]);
    }
   

    public function getSubjectMarks($id)
    {
        $subjects = \App\Models\Subject::where('student_id', $id)->get();
    
        return response()->json($subjects);
    }

    public function getSubjectPerformance($id)
    {
        $student = Student::with('subjects')->findOrFail($id);
    
        $currentTermMarks = [];
        $previousTermMarks = [];
        $subjects = [];
    
        foreach ($student->subjects as $subject) {
            $subjects[] = $subject->name;
            $currentTermMarks[] = $subject->current_term_mark;
            $previousTermMarks[] = $subject->previous_term_mark;
        }
    
        return response()->json([
            'subjects' => $subjects,
            'current' => $currentTermMarks,
            'previous' => $previousTermMarks,
        ]);
    }
      
    public function getPerformanceDistribution()
{
    $ranges = [
        '<60%' => [0, 59],
        '60-70%' => [60, 69],
        '70-80%' => [70, 79],
        '80-90%' => [80, 89],
        '90-100%' => [90, 100],
    ];

    $students = DB::table('students')->select('class', 'performance')->get();

    $grouped = [];

    foreach ($students as $student) {
        $performance = (int) filter_var($student->performance, FILTER_SANITIZE_NUMBER_INT);
        foreach ($ranges as $label => [$min, $max]) {
            if ($performance >= $min && $performance <= $max) {
                $grouped[$student->class][$label] = ($grouped[$student->class][$label] ?? 0) + 1;
                break;
            }
        }
    }

    $result = [
        'ranges' => array_keys($ranges),
        'series' => []
    ];

    foreach ($grouped as $class => $data) {
        $result['series'][] = [
            'name' => $class,
            'type' => 'bar',
            'data' => array_map(fn($label) => $data[$label] ?? 0, array_keys($ranges))
        ];
    }

    return response()->json($result);
}


    // Method to get parent information by student ID
    public function getParent($id)
    {
        // Find the student by ID
        $student = Student::find($id);

        // Check if student exists
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        // Get the parent information associated with this student
        $parent = $student->parent;

        // If no parent found, return a response saying so
        if (!$parent) {
            return response()->json(['message' => 'Parent not found'], 404);
        }

        // Return the parent information as a response
        return response()->json($parent);
    }
    public function index(Request $request)
    {
        $query = Student::query();
    
        // Optional filters
          $query->where(function ($q) use ($request) {
        $q->where('first_name', 'like', '%' . $request->name . '%')
          ->orWhere('last_name', 'like', '%' . $request->name . '%')
          ->orWhere('student_id', 'like', '%' . $request->name . '%')
          ->orWhere('class', 'like', '%' . $request->name . '%')
          ->orWhere('email', 'like', '%' . $request->name . '%');
    });
        return response()->json($query->paginate(5));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:students,email',
        'student_id' => 'required|string|unique:students,student_id',
        'class' => 'required|string',
        'performance' => 'required|string',
        'attendance' => 'required|string',
        'contact' => 'required|string',
        'status' => 'required|string',
        'date_of_birth' => 'required|date',
        'gender' => 'required|string',
        'enrollment_date' => 'required|date',
        'address' => 'required|string',
        'parent' => 'required|array',
        'parent.name' => 'required|string',
        'parent.relationship' => 'required|string',
        'parent.email' => 'required|email|unique:parents,email',
        'parent.phone_number' => 'required|string',
    ]);

    $student = \App\Models\Student::create($validated);

    $student->parent()->create([
        'name' => $validated['parent']['name'],
        'relationship' => $validated['parent']['relationship'],
        'email' => $validated['parent']['email'],
        'phone_number' => $validated['parent']['phone_number'],
    ]);

    return response()->json([
        'message' => 'Student and parent created successfully',
        'student' => $student->load('parent'),
    ], 201);
}

public function update(Request $request, $id)
{
    $student = \App\Models\Student::findOrFail($id);

    $validated = $request->validate([
        'first_name' => 'sometimes|required|string|max:255',
        'last_name' => 'sometimes|required|string|max:255',
        'email' => 'sometimes|required|email|unique:students,email,' . $student->id,
        'student_id' => 'sometimes|required|string|unique:students,student_id,' . $student->id,
        'class' => 'sometimes|required|string',
        'performance' => 'sometimes|required|string',
        'attendance' => 'sometimes|required|string',
        'contact' => 'sometimes|required|string',
        'status' => 'sometimes|required|string',
        'date_of_birth' => 'sometimes|required|date',
        'gender' => 'sometimes|required|string',
        'enrollment_date' => 'sometimes|required|date',
        'address' => 'sometimes|required|string',
    ]);

    $student->update($validated);

    return response()->json([
        'message' => 'Student updated successfully',
        'student' => $student
    ]);
}

public function destroy($id)
{
    $student = \App\Models\Student::findOrFail($id);

    // Delete parent first due to foreign key
    $student->parent()->delete();

    $student->delete();

    return response()->json([
        'message' => 'Student and associated parent deleted successfully'
    ]);
}

}