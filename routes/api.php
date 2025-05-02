<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;

// Fetch all students
Route::get('/students', [StudentController::class, 'index']);
//Add Students
Route::post('/students', [StudentController::class, 'store']);
//Update Students
Route::put('/students/{id}', [StudentController::class, 'update']);
//Delete Students
Route::delete('/students/{id}', [StudentController::class, 'destroy']);
//Student summary
Route::get('/student-summary', [DashboardController::class, 'studentSummary']);
//get perent information by student ID
Route::get('/students/{id}/parent', [StudentController::class, 'getParent']);
//Performace graph
Route::get('/students/performance-distribution', [StudentController::class, 'getPerformanceDistribution']);
//Attendance graph
Route::get('/student/{id}/performance', [StudentController::class, 'getSubjectPerformance']);
//Subject marks
Route::get('/student/{id}/subject-marks', [StudentController::class, 'getSubjectMarks']);
//Attendance graph
Route::get('/student/{id}/attendance-stats', [StudentController::class, 'getAttendanceStats']);
