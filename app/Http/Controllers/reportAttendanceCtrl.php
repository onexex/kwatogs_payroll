<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceSummary;
use App\Models\User;

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

        return response()->json($query->get());
    }
}
