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

 
    public function calculateNightDiff(Carbon $actualIn, Carbon $actualOut)
    {
        $nightDiffMinutes = 0;
        $current = $actualIn->copy()->startOfDay();

        while ($current->lt($actualOut)) {
            $nightStart = $current->copy()->setTime(22, 0); // 10 PM
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

        // 5️⃣ --- NEW: Over-break & Outpass detection ---
        $overBreak = 0;
        $outPass = 0;

        if ($schedule && $schedule->break_start && $schedule->break_end) {
            $breakStart = Carbon::parse($schedule->sched_start_date . ' ' . $schedule->break_start);
            $breakEnd = Carbon::parse($schedule->sched_start_date . ' ' . $schedule->break_end);
            $expectedBreak = $breakEnd->diffInMinutes($breakStart);

            // Sort logs by time_in
            $sortedLogs = $logs->sortBy('time_in')->values();

            for ($i = 0; $i < count($sortedLogs) - 1; $i++) {
                $timeOut = Carbon::parse($sortedLogs[$i]->time_out);
                $nextIn = Carbon::parse($sortedLogs[$i + 1]->time_in);
                $gap = $timeOut->diffInMinutes($nextIn);

                // Gap occurs during break period
                if ($timeOut->between($breakStart, $breakEnd) || $nextIn->between($breakStart, $breakEnd)) {
                    if ($gap > $expectedBreak) {
                        $overBreak += ($gap - $expectedBreak);
                    }
                } else {
                    // Accidental outpass (gap not within break)
                    // if ($gap >= 5) { // optional threshold to ignore very small gaps
                        $outPass += $gap;
                    // }
                }
            }
        }

        $summary->over_break_minutes = $overBreak;
        $summary->outpass_minutes = $outPass;

        // 6️⃣ Determine attendance status
        $summary->status = $summary->total_hours > 0 ? 'Present' : 'Absent';

        $summary->save();
    }

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

        //  LUNCH BREAK HANDLING
        if ($schedule && $schedule->break_start && $schedule->break_end) {
        
            // Build Carbon timestamps for the break period
            $breakStart = Carbon::parse($actualIn->toDateString() . ' ' . $schedule->break_start);
            $breakEnd = Carbon::parse($actualIn->toDateString() . ' ' . $schedule->break_end);
       
            // If employee TIME-OUT happens during break → mark as lunch break
            if ($timeOut->between($breakStart, $breakEnd)) {
                // $this->time_out = $timeOut;
                $this->remarks = 'Lunch Break';    
                $this->save();
                // return $this;
                
            }
            $breakDuration = 0;

            if ($actualIn->lte($breakStart) && $timeOut->gte($breakEnd)) {
                $breakDuration = $breakEnd->diffInMinutes($breakStart);
            } 
            // elseif ($actualIn->lte($breakStart) && $timeOut->between($breakStart, $breakEnd)) {
            //     $breakDuration = $timeOut->diffInMinutes($breakStart);
            // }
             elseif ($actualIn->between($breakStart, $breakEnd) && $timeOut->gte($breakEnd)) {
                $breakDuration = $breakEnd->diffInMinutes($actualIn);
            } elseif ($actualIn->between($breakStart, $breakEnd) && $timeOut->between($breakStart, $breakEnd)) {
                $breakDuration = $timeOut->diffInMinutes($actualIn);
            } else {
                $breakDuration = 0;
            }
        }

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

        // Convert punch duration to minutes
        $totalMinutes = $evaluated['duration_hours'] * 60;

        // Deduct lunch break minutes if applicable
        // if (isset($this->break_minutes) && $this->break_minutes > 0) {
        //     $totalMinutes -= $this->break_minutes;
        // }
        // Deduct break
        $totalMinutes -= $breakDuration;

        // Prevent negative result
        $totalMinutes = max($totalMinutes, 0);

        // Recompute into hours
        $this->duration_hours = $totalMinutes / 60;
        //   $evaluated = $this->evaluatePunch($actualIn, $actualOut);

        // $this->duration_hours = $evaluated['duration_hours'];
  
        $this->night_diff_hours = $evaluated['night_diff_hours'];
        $this->remarks = $evaluated['remarks'];
        $this->save();

        // ✅ Update summary only if valid or overnight
        if (empty($evaluated['remarks']) || str_contains($evaluated['remarks'], 'Overnight')) {
            $this->updateDailySummary();
        }

        return $this;
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

            // if ($matchedSchedule && $matchedSchedule->break_start && $matchedSchedule->break_end) {
            //     $breakStart = Carbon::parse($today . ' ' . $matchedSchedule->break_start);
            //     $breakEnd = Carbon::parse($today . ' ' . $matchedSchedule->break_end);

            //     // If employee tries to time-in during break → reject
            //     if ($now->between($breakStart, $breakEnd)) {
            //         throw new \Exception("You are still on lunch break. Time-in allowed after {$matchedSchedule->break_end}.");
            //     }
            // }
            if ($matchedSchedule && $matchedSchedule->break_start && $matchedSchedule->break_end) {
                $breakStart = Carbon::parse($today . ' ' . $matchedSchedule->break_start);
                $breakEnd = Carbon::parse($today . ' ' . $matchedSchedule->break_end);

                // Allow early return: 10 minutes before break end
                $earlyReturn = $breakEnd->copy()->subMinutes(10);

                if ($now->between($breakStart, $earlyReturn)) {
                    throw new \Exception("You are still on lunch break. Time-in allowed after {$earlyReturn->format('H:i')}.");
                }

                // If within the last 10 minutes of lunch, auto-adjust punch to break end
                if ($now->between($earlyReturn, $breakEnd)) {
                    $now = $breakEnd->copy(); // override punch time
                }
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


        



    }
