<?php
namespace App\Http\Controllers;

use App\Models\EmpDetail;
use App\Models\EmployeeSchedule;
use App\Models\Payroll;
use App\Models\PayrollDetail;
use App\Models\User;

class PayrollController extends Controller
{

    public function computePayroll()
    {
        $employees = User::with('empDetail')
            ->whereHas('empDetail', function ($q) {
                $q->where('empStatus', '1');
            })
            ->get();
        $startDate = '2025-10-01';
        $endDate   = '2025-10-15';
        foreach ($employees as $emp) {

            $salary = $emp->empDetail->getSalaryInfo();

            $absentDays       = 0;
            $totalHoursWorked = 0;
            $totalOT          = 0;
            $totalLate        = 0;
            $totalUndertime   = 0;

            // Get schedules within payroll period
            $employeeSchedules = EmployeeSchedule::where('employee_id', $emp->empID)
                ->whereBetween('sched_start_date', [$startDate, $endDate])
                ->with('attendanceSummaries')
                ->get();

            foreach ($employeeSchedules as $schedule) {
                $date = $schedule->sched_start_date;

                // Check attendance for this day
                $summary = $schedule->attendanceSummaries
                    ->where('attendance_date', $date)
                    ->first();

                // Check leave
                // $hasLeave = Leave::where('employee_id', $emp->empID)
                //     ->where('leave_date', $date)
                //     ->exists();

                // // Check OB
                // $hasOB = OB::where('employee_id', $emp->empID)
                //     ->where('ob_date', $date)
                //     ->exists();
                $hasOB    = 0;
                $hasLeave = 0;

                // Absent if no attendance, no leave, no OB
                if ((! $summary || $summary->total_hours == 0) && ! $hasLeave && ! $hasOB) {
                    $absentDays++;
                }

                if ($summary) {
                    $totalHoursWorked += $summary->total_hours;
                    $totalOT += $summary->ot_hours;
                    $totalLate += $summary->mins_late;
                    $totalUndertime += $summary->mins_undertime;
                }
            }

            // Compute deductions and pay

            $allowance  = $salary['allowance'];
            $empBasic   = $salary['basic'];
            $dailyRate  = $empBasic / 26;
            $hourlyRate = $dailyRate / 8;
            // dd($empBasic);
            // dd($emp->empID);

            $regularPay         = ($totalHoursWorked / 8) * $hourlyRate;
            $otPay              = $totalOT * ($hourlyRate * 1.25); // OT 25% multiplier
            $lateDeduction      = ($totalLate / 60) * $hourlyRate;
            $undertimeDeduction = ($totalUndertime / 60) * $hourlyRate;
            $absentDeduction    = $absentDays * $dailyRate;

            $grossPay = $regularPay + $otPay + $allowance - ($lateDeduction + $undertimeDeduction + $absentDeduction);

            // TODO: apply SSS, PhilHealth, Pag-IBIG, BIR, loans
            $deductions =    $absentDeduction + $lateDeduction + $undertimeDeduction;

            $netPay = $grossPay - $deductions;

            // Save payroll
            $payroll = Payroll::updateOrCreate(
                [
                    'employee_id'        => $emp->empID,
                    'payroll_start_date' => $startDate,
                    'payroll_end_date'   => $endDate,
                    'basic_salary'   =>   $empBasic  ,
                    'allowances'   =>   $allowance  ,
                    'total_deductions'   =>   $deductions  ,
                    
                ],
                [
                    'gross_pay' => $grossPay,
                    'net_pay'   => $netPay,
                ]
            );

            // Save payroll details
            PayrollDetail::updateOrCreate(
                [
                    'payroll_id'  => $payroll->id,
                    'employee_id' => $emp->empID,
                ],
                [
                    'regular_pay'         => $regularPay,
                    'ot_pay'              => $otPay,
                    'allowance'           => $allowance,
                    'late_deduction'      => $lateDeduction,
                    'undertime_deduction' => $undertimeDeduction,
                    'absent_deduction'    => $absentDeduction,
                    'deductions'          => $deductions,
                    'net_pay'             => $netPay,
                ]
            );
        }

        return "Payroll computed successfully for period $startDate to $endDate";
    }

}
