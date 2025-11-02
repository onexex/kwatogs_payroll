<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Overtime;
use Illuminate\Http\Request;
use App\Models\EmployeeSchedule;
use App\Enums\OvertimeStatusEnum;
use Illuminate\Support\Facades\Auth;

class OvertimeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $overtimes = Overtime::where('emp_detail_id', $user->empDetail->id)
            ->orderByDesc('created_at')
            ->paginate(10)
            ->through(function ($ot) {
                $from = Carbon::parse($ot->date_from . ' ' . $ot->time_in);
                $to = Carbon::parse($ot->date_to . ' ' . $ot->time_out);

                $hours = $from->diffInHours($to);
                $minutes = $from->diffInMinutes($to) % 60;

                return [
                    'id' => $ot->id,
                    'filing_datetime' => Carbon::parse($ot->created_at)->format('M d, Y h:i A'),
                    'time_in' => $from->format('M d, Y h:i A'),
                    'time_out' => $to->format('M d, Y h:i A'),
                    'purpose' => $ot->purpose,
                    'duration' => sprintf('%d hr %d min', $hours, $minutes),
                    'status' => strtoupper($ot->status ?? 'PENDING'),
                    'status_value' => OvertimeStatusEnum::fromName($ot->status),
                ];
            });
        
        return view('pages.modules.overtime', compact('overtimes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dateFrom' => [
                'required', 'date',
                function ($attribute, $value, $fail) use ($request) {
                    $from = Carbon::parse($request->dateFrom . ' ' . $request->timeFrom);
                    $to   = Carbon::parse($request->dateTo . ' ' . $request->timeTo);

                    if ($from->greaterThanOrEqualTo($to)) {
                        $fail('The start date and time must be earlier than the end date and time.');
                    }
                },
            ],
            'dateTo'   => ['required', 'date', 'after_or_equal:dateFrom'],
            'timeFrom' => ['required'],
            'timeTo'   => ['required'],
            'purpose'  => ['nullable', 'string', 'max:255'],
        ]);

        $fromDateTime = Carbon::parse($request->dateFrom . ' ' . $request->timeFrom);
        $toDateTime   = Carbon::parse($request->dateTo . ' ' . $request->timeTo);
        $user = Auth::user();

        if ($user ) {
            $schedules = EmployeeSchedule::where('employee_id', $user->empID)
                ->whereDate('sched_start_date', '<=', $request->dateTo)
                ->whereDate('sched_end_date', '>=', $request->dateFrom)
                ->get();

            $hasOverlap = $schedules->contains(function ($schedule) use ($fromDateTime, $toDateTime) {
                $schedStart = Carbon::parse($schedule->sched_start_date . ' ' . $schedule->sched_in);
                $schedEnd   = Carbon::parse($schedule->sched_end_date . ' ' . $schedule->sched_out);

                return $fromDateTime->lt($schedEnd) && $toDateTime->gt($schedStart);
            });

            if ($hasOverlap) {
                return back()->withErrors([
                    'dateFrom' => 'You already have a work schedule that overlaps this time range. Overtime is not allowed within scheduled hours.'
                ])->withInput();
            }


            $overtime = Overtime::create([
                'emp_detail_id' => $user->empDetail->id,
                'status' => OvertimeStatusEnum::FORAPPROVAL->name,
                'date_from' => $request->dateFrom,
                'date_to' => $request->dateTo,  
                'time_in' => $request->timeFrom,   
                'time_out' => $request->timeTo,   
                'purpose' => $request->purpose,    
            ]);

            return back()->with('success', 'Overtime filed successfully!');
        }
    }

    public function updateStatus(Overtime $overtime, Request $request) 
    {
        if ($overtime) {
            

            $overtime->status = $request->status;
            $overtime->save();

            return back()->with('success', 'Overtime updated status!');
        }

    }
}
