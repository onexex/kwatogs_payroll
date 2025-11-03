<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceSummary;
use App\Models\User;
    use Carbon\Carbon;

class reportAttendanceCtrl extends Controller
{
    public function index()
    {
        $resultEmp = User::select('empID', 'fname', 'lname')->orderBy('lname')->get();
        return view('reports.attendance', compact('resultEmp'));
    }



public function fetchAttendance(Request $request)
{
    $request->validate([
        'date_from' => 'required|date',
        'date_to'   => 'required|date',
        'employee_id' => 'nullable'
    ]);

    $query = AttendanceSummary::with(['employee', 'homeAttendances'])
        ->whereBetween('attendance_date', [$request->date_from, $request->date_to])
        ->orderBy('attendance_date', 'asc');

    if ($request->employee_id && $request->employee_id !== 'All') {
        $query->where('employee_id', $request->employee_id);
    }

    $records = $query->get();

    $records->each(function ($item) {
        // Filter attendances for the current summary date
        $item->filtered_attendances = $item->homeAttendances
            ->whereBetween('attendance_date', [
                $item->attendance_date . ' 00:00:00',
                $item->attendance_date . ' 23:59:59'
            ]);

        $first = $item->filtered_attendances->sortBy('time_in')->first();
        $last = $item->filtered_attendances->sortByDesc('time_out')->first();

        // Convert all timestamps to Asia/Manila timezone
        $tz = 'Asia/Manila';

        // Format attendance date as YYYY-MM-DD (local time)
        $item->formatted_date = Carbon::parse($item->attendance_date)
            ->timezone($tz)
            ->format('Y-m-d');

        // Format time-in and time-out as "YYYY-MM-DD hh:mm A" (local time)
        $item->first_time_in = $first && $first->time_in 
            ? Carbon::parse($first->time_in)->timezone($tz)->format('Y-m-d h:i A')
            : '-';

        $item->last_time_out = $last && $last->time_out 
            ? Carbon::parse($last->time_out)->timezone($tz)->format('Y-m-d h:i A')
            : '-';
    });

    return response()->json($records);
}



}
