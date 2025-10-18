<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HomeAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'employee_id',
        'attendance_date',
        'time_in',
        'time_out',
        'duration_hours',
        'night_diff_hours',
        'status',
        'remarks',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'time_in' => 'datetime',
        'time_out' => 'datetime',
        'duration_hours' => 'decimal:2',
        'night_diff_hours' => 'decimal:2',
    ];

    // -----------------------
    // Relationships
    // -----------------------
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id', 'empID');
    }

    public function schedule()
    {
        return $this->belongsTo(EmployeeSchedule::class, 'schedule_id');
    }

    public function summary()
    {
        return $this->belongsTo(AttendanceSummary::class, 'employee_id', 'employee_id')
                    ->whereColumn('attendance_date', 'home_attendances.attendance_date');
    }

    // -----------------------
    // Helpers
    // -----------------------
    public function getTotalHoursAttribute()
    {
        if ($this->time_in && $this->time_out) {
            return round(Carbon::parse($this->time_out)->diffInMinutes(Carbon::parse($this->time_in)) / 60, 2);
        }
        return 0;
    }

    public function isOvernight()
    {
        if (!$this->time_in || !$this->time_out) return false;
        return Carbon::parse($this->time_out)->isAfter(Carbon::parse($this->time_in)->endOfDay());
    }

    // -----------------------
    // Log Time In
    // -----------------------
    // public static function logTimeIn($employeeId)
    // {
    //     $today = now()->toDateString();

    //     // 🧩 STEP 1: Find open logs BEFORE today (missed logout)
    //     $previousOpenLogs = self::where('employee_id', $employeeId)
    //         ->whereNull('time_out')
    //         ->whereDate('attendance_date', '<', $today)
    //         ->get();

    //     foreach ($previousOpenLogs as $log) {
    //         $timeIn = Carbon::parse($log->time_in);
    //         $hoursDiff = $timeIn->diffInHours(now());

    //         if ($hoursDiff > 12) {
    //             // ✅ Auto-close old logs safely (missed logout)
    //             // $log->time_out = $timeIn->copy()->addHours(12);
    //             $log->time_out = $timeIn ;
    //             $log->duration_hours = 0;
    //             $log->night_diff_hours = 0;
    //             $log->remarks = 'Auto-closed (Missed logout)';
    //             $log->save();
    //         }
    //     }

    //     // 🧩 STEP 2: Check if there's still an open log today
    //     $openToday = self::where('employee_id', $employeeId)
    //         ->whereDate('attendance_date', $today)
    //         ->whereNull('time_out')
    //         ->first();

    //     if ($openToday) {
    //         throw new \Exception('You still have an active punch today. Please log out before punching in again.');
    //     }

    //     // 🧩 STEP 3: Get today’s schedule
    //     $schedule = EmployeeSchedule::where('employee_id', $employeeId)
    //         ->whereDate('sched_start_date', '<=', $today)
    //         ->whereDate('sched_end_date', '>=', $today)
    //         ->first();

    //     // 🧩 STEP 4: Create new record for today
    //     return self::create([
    //         'employee_id' => $employeeId,
    //         'schedule_id' => $schedule?->id,
    //         'attendance_date' => $today,
    //         'time_in' => now(),
    //         'status' => 'Present',
    //     ]);
    // }


    // -----------------------
    // Log Time Out
    // -----------------------
  

    // public function logTimeOut($timeOut = null)
    // {
    //     $timeOut = $timeOut ?: now();
    //     $this->time_out = Carbon::parse($timeOut);

    //     if (!$this->time_in) {
    //         $this->duration_hours = 0;
    //         $this->night_diff_hours = 0;
    //         $this->remarks = 'Invalid (No time-in found)';
    //         $this->save();
    //         return $this;
    //     }

    //     $actualIn  = Carbon::parse($this->time_in);
    //     $actualOut = Carbon::parse($this->time_out);

    //     // Prevent negative or same timestamp
    //     if ($actualOut->lt($actualIn)) {
    //         $actualOut = $actualIn->copy();
    //     }

    //     $isInvalid = false;

    //     // 🧩 Check if scheduled
    //     if ($this->schedule) {
    //         $schedOut = Carbon::parse($this->schedule->sched_out);

    //         // Auto-close logic applies only for previous-day punches
    //         if ($actualIn->lt(Carbon::today())) {
    //             $actualOut = $schedOut->copy()->addHours(12);
    //             $isInvalid = true;
    //             $this->remarks = 'Auto-closed (Missed logout)';
    //         } 
    //         // Normal same-day over-12-hours check
    //         elseif ($actualOut->gt($schedOut->copy()->addHours(12))) {
    //             $isInvalid = true;
    //             $this->remarks = 'Invalid (Over 12 hours)';
    //         }
    //     } else {
    //         // No schedule: fallback
    //         if ($actualOut->diffInHours($actualIn) > 12) {
    //             $isInvalid = true;
    //             $this->remarks = 'Invalid (Over 12 hours)';
    //         }
    //     }

    //     // 🧩 Apply duration and night diff
    //     if ($isInvalid) {
    //         $this->duration_hours = 0;
    //         $this->night_diff_hours = 0;
    //     } else {
    //         $this->duration_hours = round($actualOut->diffInMinutes($actualIn) / 60, 2);
    //         $this->night_diff_hours = $this->calculateNightDiff($actualIn, $actualOut);
    //         $this->remarks = $this->isOvernight() ? 'Overnight shift' : $this->remarks;
    //     }

    //     $this->save();

    //     // Update daily summary if method exists
    //     if (method_exists($this, 'updateDailySummary')) {
    //         $this->updateDailySummary();
    //     }

    //     return $this;
    // }


    // -----------------------
    // Night Diff Calculation
    // -----------------------
    public function calculateNightDiff(Carbon $actualIn, Carbon $actualOut)
    {
        $nightDiffMinutes = 0;
        $current = $actualIn->copy()->startOfDay();

        while ($current->lt($actualOut)) {
            $nightStart = $current->copy()->setTime(20, 0); // 8 PM
            $nightEnd   = $current->copy()->addDay()->setTime(6, 0); // 6 AM next day

            $start = $actualIn->greaterThan($nightStart) ? $actualIn : $nightStart;
            $end   = $actualOut->lessThan($nightEnd) ? $actualOut : $nightEnd;

            if ($end->gt($start)) {
                $nightDiffMinutes += $end->diffInMinutes($start);
            }

            $current->addDay();
        }

        return round($nightDiffMinutes / 60, 2);
    }

    public function updateDailySummary()
    {
        $attendanceDate = $this->attendance_date instanceof Carbon
            ? $this->attendance_date->toDateString()
            : Carbon::parse($this->attendance_date)->toDateString();

        // 1️⃣ Get or create daily summary
        $summary = AttendanceSummary::firstOrCreate([
            'employee_id' => $this->employee_id,
            'attendance_date' => $attendanceDate,
        ]);

        // 2️⃣ Get attendance logs for this exact attendance date only
        $logs = self::where('employee_id', $this->employee_id)
            ->whereDate('attendance_date', $attendanceDate)
            ->get();

        // 3️⃣ Sum total hours and night differential
        $summary->total_hours = round($logs->sum('duration_hours'), 2);
        $summary->mins_night_diff = (int) $logs->sum(fn($log) => $log->night_diff_hours * 60);

        // 4️⃣ Fetch schedule valid for this attendance date
        $schedule = EmployeeSchedule::where('employee_id', $this->employee_id)
            ->whereDate('sched_start_date', '<=', $attendanceDate)
            ->whereDate('sched_end_date', '>=', $attendanceDate)
            ->orderBy('sched_start_date', 'desc')
            ->first();

        if ($schedule && $logs->count()) {
            $firstIn = Carbon::parse($logs->sortBy('time_in')->first()->time_in);
            $lastOut = Carbon::parse($logs->sortByDesc('time_out')->first()->time_out);

            $schedIn = Carbon::parse($schedule->sched_start_date . ' ' . $schedule->sched_in);
            $schedOut = Carbon::parse($schedule->sched_end_date . ' ' . $schedule->sched_out);

            // Overnight adjustment: only if schedule crosses days
            if ($schedOut->lessThanOrEqualTo($schedIn)) {
                $schedOut->addDay();
            }

            // Calculate late minutes
            $summary->mins_late = $firstIn->gt($schedIn)
                ? $schedIn->diffInMinutes($firstIn)
                : 0;

            // Calculate undertime minutes
            $summary->mins_undertime = $lastOut->lt($schedOut)
                ? $lastOut->diffInMinutes($schedOut)
                : 0;

        } else {
            $summary->mins_late = 0;
            $summary->mins_undertime = 0;
        }

        // 5️⃣ Determine attendance status
        $summary->status = $summary->total_hours > 0 ? 'Present' : 'Absent';
        $summary->save();
    }

        /**
     * Check if a punch is invalid or needs auto-close
     * Returns an array with updated time_out, duration_hours, night_diff_hours, remarks
     */
    protected function evaluatePunch($actualIn, $actualOut)
    {
        $result = [
            'time_out' => $actualOut,
            'duration_hours' => 0,
            'night_diff_hours' => 0,
            'remarks' => null,
        ];

        $isInvalid = false;

        if ($this->schedule) {
            // Build full datetime for sched_in and sched_out
            $schedInDateTime = Carbon::parse($this->schedule->sched_start_date . ' ' . $this->schedule->sched_in);
            $schedOutDateTime = Carbon::parse($this->schedule->sched_end_date . ' ' . $this->schedule->sched_out);

            // Overnight adjustment
            if ($schedOutDateTime->lessThanOrEqualTo($schedInDateTime)) {
                $schedOutDateTime->addDay();
            }

            // 🔒 Validation: missed logout (if time_in was yesterday and no logout)
            if ($actualIn->lt($schedInDateTime->copy()->subDay())) {
                $isInvalid = true;
                $result['remarks'] = 'Auto-closed (Missed logout)';
            }

            // 🔒 Validation: absurdly long punch (max 16h)
            elseif ($actualOut->gt($actualIn->copy()->addHours(16))) {
                $isInvalid = true;
                $result['remarks'] = 'Invalid (Over 16 hours)';
            }

            // ✅ Cap the actualOut at schedule end for duration calculation
            $calcOut = $actualOut->gt($schedOutDateTime) ? $schedOutDateTime->copy() : $actualOut->copy();
        } else {
            // No schedule: use actualOut as-is
            $calcOut = $actualOut->copy();

            // Validation: max 16h
            if ($calcOut->diffInHours($actualIn) > 16) {
                $isInvalid = true;
                $result['remarks'] = 'Invalid (Over 16 hours)';
            }
        }

        // ✅ Compute duration if valid
        if (!$isInvalid) {
            $result['duration_hours'] = round($calcOut->diffInMinutes($actualIn) / 60, 2);
            $result['night_diff_hours'] = $this->calculateNightDiff($actualIn, $calcOut);

            // Mark if overnight
            if ($calcOut->isNextDay($actualIn) || $calcOut->lt($actualIn)) {
                $result['remarks'] = 'Overnight shift';
            }
        }

        // Keep the original time_out for logging, but duration respects schedule
        $result['time_out'] = $actualOut;

        return $result;
    }

    public static function logTimeIn($employeeId)
    {
        $now = now();
        $today = $now->toDateString();
        $yesterday = $now->copy()->subDay()->toDateString();

        // Auto-close previous open logs (same as your version)
        $previousOpenLogs = self::where('employee_id', $employeeId)
            ->whereNull('time_out')
            ->whereDate('attendance_date', '<', $today)
            ->get();

        foreach ($previousOpenLogs as $log) {
            $evaluated = $log->evaluatePunch(Carbon::parse($log->time_in), $now);
            $log->time_out = $evaluated['time_out'] ?? $now;
            $log->duration_hours = $evaluated['duration_hours'] ?? 0;
            $log->night_diff_hours = $evaluated['night_diff_hours'] ?? 0;
            $log->remarks = $evaluated['remarks'] ?? $log->remarks;
            $log->save();
        }

        // Prevent duplicate open punches
        $openToday = self::where('employee_id', $employeeId)
            ->whereDate('attendance_date', $today)
            ->whereNull('time_out')
            ->first();

        if ($openToday) {
            throw new \Exception('You still have an active punch today. Please log out before punching in again.');
        }

        // ---- Schedule detection ----
        $bufferMinutes = 60; // allow 1h early or late
        $allowWithoutSchedule = false;

        // Find schedules that overlap [yesterday → tomorrow] to catch overnight and normal
        $tomorrow = $now->copy()->addDay()->toDateString();

        $candidates = EmployeeSchedule::where('employee_id', $employeeId)
            ->where(function ($q) use ($yesterday, $tomorrow) {
                $q->whereBetween('sched_start_date', [$yesterday, $tomorrow])
                ->orWhereBetween('sched_end_date', [$yesterday, $tomorrow]);
            })
            ->get();

        $matchedSchedule = null;

        foreach ($candidates as $s) {
            $schedIn = Carbon::parse($s->sched_start_date . ' ' . $s->sched_in);
            $schedOut = Carbon::parse($s->sched_end_date . ' ' . $s->sched_out);

            // Overnight check
            if ($schedOut->lessThanOrEqualTo($schedIn)) {
                $schedOut->addDay();
            }

            $windowStart = $schedIn->copy()->subMinutes($bufferMinutes);
            $windowEnd = $schedOut->copy()->addMinutes($bufferMinutes);

            if ($now->between($windowStart, $windowEnd)) {
                $matchedSchedule = $s;
                break;
            }
        }

        if (!$matchedSchedule && !$allowWithoutSchedule) {
            throw new \Exception('No active schedule found for your time-in today.');
        }

        // Create attendance
        return self::create([
            'employee_id' => $employeeId,
            'schedule_id' => $matchedSchedule?->id,
            'attendance_date' => $today,
            'time_in' => $now,
            'status' => 'Present',
        ]);
    }

    public function logTimeOut($timeOut = null)
    {
        $timeOut = Carbon::parse($timeOut ?: now());
        $this->time_out = $timeOut;

        if (!$this->time_in) {
            $this->duration_hours = 0;
            $this->night_diff_hours = 0;
            $this->remarks = 'Invalid (No time-in found)';
            $this->save();
            $this->updateDailySummary();
            return $this;
        }

        $actualIn = Carbon::parse($this->time_in);
        $actualOut = $timeOut->copy();

        // Prevent reversed times
        if ($actualOut->lt($actualIn)) {
            $actualOut = $actualIn->copy();
            $this->time_out = $actualOut;
        }

        // 🔍 Retrieve correct schedule for this punch
        $schedule = $this->schedule;

        if (!$schedule) {
            // Fallback: find schedule based on the IN date or OUT date
            $schedule = EmployeeSchedule::where('employee_id', $this->employee_id)
                ->where(function ($q) use ($actualIn, $actualOut) {
                    $q->whereBetween('sched_start_date', [$actualIn->toDateString(), $actualOut->toDateString()])
                    ->orWhereBetween('sched_end_date', [$actualIn->toDateString(), $actualOut->toDateString()]);
                })
                ->first();
        }

        // If still no schedule, last resort is today's
        if (!$schedule) {
            $schedule = EmployeeSchedule::where('employee_id', $this->employee_id)
                ->whereDate('sched_start_date', '<=', $actualOut->toDateString())
                ->whereDate('sched_end_date', '>=', $actualOut->toDateString())
                ->first();
        }

        $this->schedule_id = $schedule?->id ?? $this->schedule_id;

        // 🧮 Evaluate punch (handles overnight or normal)
        $evaluated = $this->evaluatePunch($actualIn, $actualOut);

        $this->duration_hours = $evaluated['duration_hours'];
        $this->night_diff_hours = $evaluated['night_diff_hours'];
        $this->remarks = $evaluated['remarks'];

        $this->save();

        // ✅ Update summary only if valid or overnight
        if (empty($evaluated['remarks']) || str_contains($evaluated['remarks'], 'Overnight')) {
            $this->updateDailySummary();
        }

        return $this;
    }




    



}
