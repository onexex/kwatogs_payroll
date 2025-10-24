<?php

namespace App\Http\Controllers;

use App\Models\EmployeeSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EmployeeScheduleController extends Controller
{
    public function index()
    {
        $employees = User::orderBy('lname')->get();
      
        return view('pages.management.empscheduler', compact('employees'));
    }

    // Get all schedules (for AJAX table)
    // public function getSchedules(Request $request)
    // {
    //     $search = $request->search ?? '';
    //     $query = EmployeeSchedule::with('users')
    //         ->when($search, fn($q) => $q->whereHas('users', fn($e) =>
    //             $e->where('fname','like',"%$search%")->orWhere('lname','like',"%$search%")
    //         ));

    //     $schedules = $query->orderBy('sched_start_date', 'asc')->get();

    //     $schedules->transform(fn($s) => [
    //         'id' => $s->id,
    //         'employee_name' => $s->users->lname . ', ' . $s->users->fname,
    //         'sched_start_date' => $s->sched_start_date,
    //         'sched_in' => $s->sched_in,
    //         'sched_end_date' => $s->sched_end_date,
    //         'sched_out' => $s->sched_out,
    //         'shift_type' => $s->shift_type
    //     ]);

    //     return response()->json($schedules);
    // }

    public function getSchedules(Request $request)
{
    $search = $request->search ?? '';
    $perPage = $request->per_page ?? 10;

    $query = EmployeeSchedule::with('users')
        ->when($search, fn($q) =>
            $q->whereHas('users', fn($e) =>
                $e->where('fname', 'like', "%$search%")
                  ->orWhere('lname', 'like', "%$search%")
            )
        )
        ->join('users', 'employee_schedules.employee_id', '=', 'users.empID')
        ->orderBy('users.lname')
        ->orderBy('users.fname')
        ->orderBy('sched_start_date', 'asc')
        ->select('employee_schedules.*'); // important when joining

    $schedules = $query->paginate($perPage);

    $schedules->getCollection()->transform(fn($s) => [
        'id' => $s->id,
        'employee_name' => $s->users->lname . ', ' . $s->users->fname,
        'sched_start_date' => $s->sched_start_date,
        'sched_in' => $s->sched_in,
        'sched_end_date' => $s->sched_end_date,
        'sched_out' => $s->sched_out,
        'shift_type' => $s->shift_type
    ]);

    return response()->json($schedules);
}


    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'employee_id' => 'required|exists:users,empID',
        'sched_start_date' => 'required|date',
        'sched_end_date' => 'required|date|after_or_equal:sched_start_date',
        'sched_in' => 'required|date_format:H:i',
        'sched_out' => 'required|date_format:H:i',
        'days' => 'nullable|array',
        'shift_type' => 'nullable|string|max:50',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $employeeId = $request->employee_id;
    $start = Carbon::parse($request->sched_start_date);
    $end = Carbon::parse($request->sched_end_date);
    $days = $request->days ?? [];
    $created = 0;

    for ($date = $start->copy(); $date->lte($end); $date->addDay()) {

        if (!empty($days) && !in_array($date->format('D'), $days)) {
            continue; // Skip days not selected
        }

        // Compute actual start and end datetime
        $startDateTime = Carbon::parse($date->toDateString() . ' ' . $request->sched_in);
        $endDateTime = Carbon::parse($date->toDateString() . ' ' . $request->sched_out);

        // Overnight shift? Add 1 day to end datetime
        if ($endDateTime->lessThanOrEqualTo($startDateTime)) {
            $endDateTime->addDay();
        }

        // Check overlap using full datetime
        $overlap = EmployeeSchedule::where('employee_id', $employeeId)
            ->where(function($q) use ($startDateTime, $endDateTime) {
                $q->whereRaw(
                    "STR_TO_DATE(CONCAT(sched_start_date, ' ', sched_in), '%Y-%m-%d %H:%i') < ? AND STR_TO_DATE(CONCAT(sched_end_date, ' ', sched_out), '%Y-%m-%d %H:%i') > ?",
                    [$endDateTime, $startDateTime]
                );
            })
            ->exists();

        if ($overlap) {
            return response()->json([
                'error' => "Schedule on {$date->format('Y-m-d')} overlaps with an existing schedule."
            ], 409);
        }

        // Create schedule
        EmployeeSchedule::create([
            'employee_id' => $employeeId,
            'sched_start_date' => $startDateTime->toDateString(),
            'sched_end_date' => $endDateTime->toDateString(),
            'sched_in' => $startDateTime->format('H:i'),
            'sched_out' => $endDateTime->format('H:i'),
            'shift_type' => $request->shift_type,
        ]);

        $created++;
    }

    return response()->json(['message' => "$created schedule(s) added successfully!"]);
}



 public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'employee_id' => 'required|exists:users,empID',
        'sched_start_date' => 'required|date',
        'sched_end_date' => 'required|date|after_or_equal:sched_start_date',
        'sched_in' => 'required|date_format:H:i',
        'sched_out' => 'required|date_format:H:i',
        'shift_type' => 'nullable|string|max:50',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $schedule = EmployeeSchedule::findOrFail($id);

    $startDateTime = Carbon::parse($request->sched_start_date . ' ' . $request->sched_in);
    $endDateTime = Carbon::parse($request->sched_end_date . ' ' . $request->sched_out);

    // Overnight shift? Add 1 day to end datetime
    if ($endDateTime->lessThanOrEqualTo($startDateTime)) {
        $endDateTime->addDay();
    }

    // Check overlap excluding current schedule
    $overlap = EmployeeSchedule::where('employee_id', $request->employee_id)
        ->where('id', '!=', $id)
        ->where(function($q) use ($startDateTime, $endDateTime) {
            $q->whereRaw(
                "STR_TO_DATE(CONCAT(sched_start_date, ' ', sched_in), '%Y-%m-%d %H:%i') < ? AND STR_TO_DATE(CONCAT(sched_end_date, ' ', sched_out), '%Y-%m-%d %H:%i') > ?",
                [$endDateTime, $startDateTime]
            );
        })
        ->exists();

    if ($overlap) {
        return response()->json([
            'error' => "This schedule overlaps with an existing schedule."
        ], 409);
    }

    // Update schedule
    $schedule->update([
        'employee_id' => $request->employee_id,
        'sched_start_date' => $startDateTime->toDateString(),
        'sched_end_date' => $endDateTime->toDateString(),
        'sched_in' => $startDateTime->format('H:i'),
        'sched_out' => $endDateTime->format('H:i'),
        'shift_type' => $request->shift_type,
    ]);

    return response()->json(['message' => 'Schedule updated successfully!']);
}



    public function destroy($id)
    {
        $schedule = EmployeeSchedule::findOrFail($id);
        $schedule->delete();
        return response()->json(['message' => 'Schedule deleted successfully!']);
    }

     public function edit($id)
    {
        $schedule = EmployeeSchedule::findOrFail($id);
        return response()->json($schedule);
    }
}
