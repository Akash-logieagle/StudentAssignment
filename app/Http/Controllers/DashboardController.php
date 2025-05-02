<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Student;

class DashboardController extends Controller
{

    public function studentSummary()
    {
        // Get current period data
        $totalStudents = DB::table('students')->count();
        $averagePerformance = DB::table('students')
            ->select(DB::raw('AVG(CAST(REPLACE(performance, "%", "") AS UNSIGNED)) as avg'))
            ->value('avg');
        $averageAttendance = DB::table('students')
            ->select(DB::raw('AVG(CAST(REPLACE(attendance, "%", "") AS UNSIGNED)) as avg'))
            ->value('avg');
        $atRiskStudents = DB::table('students')
            ->whereRaw('CAST(REPLACE(performance, "%", "") AS UNSIGNED) < 60')
            ->count();

        // Get previous period data (e.g., last month) — modify query based on your requirements
        $previousTotalStudents = DB::table('students')
            ->whereDate('created_at', '<', now()->subMonth()) // Filter by last month
            ->count();

        $previousAveragePerformance = DB::table('students')
            ->whereDate('created_at', '<', now()->subMonth()) // Filter by last month
            ->select(DB::raw('AVG(CAST(REPLACE(performance, "%", "") AS UNSIGNED)) as avg'))
            ->value('avg');

        $previousAverageAttendance = DB::table('students')
            ->whereDate('created_at', '<', now()->subMonth()) // Filter by last month
            ->select(DB::raw('AVG(CAST(REPLACE(attendance, "%", "") AS UNSIGNED)) as avg'))
            ->value('avg');

        $previousAtRiskStudents = DB::table('students')
            ->whereRaw('CAST(REPLACE(performance, "%", "") AS UNSIGNED) < 60')
            ->whereDate('created_at', '<', now()->subMonth()) // Filter by last month
            ->count();

        // Calculate percentage changes
        $percentageChangeTotalStudents = $this->calculatePercentageChange($totalStudents, $previousTotalStudents);
        $percentageChangeAveragePerformance = $this->calculatePercentageChange($averagePerformance, $previousAveragePerformance);
        $percentageChangeAverageAttendance = $this->calculatePercentageChange($averageAttendance, $previousAverageAttendance);
        $percentageChangeAtRiskStudents = $this->calculatePercentageChange($atRiskStudents, $previousAtRiskStudents);

        return response()->json([
            'total_students' => $totalStudents,
            'average_performance' => round($averagePerformance, 1),
            'average_attendance' => round($averageAttendance, 1),
            'at_risk_students' => $atRiskStudents,
            'percentage_change_total_students' => $percentageChangeTotalStudents,
            'percentage_change_average_performance' => $percentageChangeAveragePerformance,
            'percentage_change_average_attendance' => $percentageChangeAverageAttendance,
            'percentage_change_at_risk_students' => $percentageChangeAtRiskStudents,
        ]);
    }

    // Helper method to calculate percentage change
    private function calculatePercentageChange($currentValue, $previousValue)
    {
        if ($previousValue == 0) {
            return 0; // Avoid division by zero
        }

        return round((($currentValue - $previousValue) / $previousValue) * 100, 1);
    }
}