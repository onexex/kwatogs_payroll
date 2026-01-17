<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeRecordController extends Controller
{
    // Load the initial Admin Search Page
    public function index() {
        $resultUser = DB::table('employees')->orderBy('lname', 'asc')->get();
        return view('pages.management.e201_admin', compact('resultUser'));
    }

    // THE GET FUNCTION: Fetch full bio-data
    public function getEmployeeDetails($empID) {
        $details = DB::table('employees as e')
            ->leftJoin('departments as d', 'e.department', '=', 'd.id')
            ->leftJoin('positions as p', 'e.position', '=', 'p.id')
            ->leftJoin('companies as c', 'e.company', '=', 'c.comp_id')
            ->leftJoin('agencies as a', 'e.agency', '=', 'a.id')
            ->leftJoin('job_levels as j', 'e.job_level', '=', 'j.id')
            ->leftJoin('hmos as h', 'e.hmo', '=', 'h.idNo')
            ->where('e.empID', $empID)
            ->first();

        if ($details) {
            return response()->json([
                'status' => 200,
                'data' => $details
            ]);
        }

        return response()->json(['status' => 404, 'message' => 'Record not found']);
    }
}