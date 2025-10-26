<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\User;
use App\Models\Payroll;
use App\Models\EmpDetail;
use App\Models\LoanPayment;
use App\Models\PayrollDetail;
use App\Models\SssContribution;
use App\Models\EmployeeSchedule;
use App\Helpers\ContributionHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class PayrollController extends Controller
{

    // public function computePayroll()
    // {
    //     // $employees = User::with('empDetail')
    //     //     ->whereHas('empDetail', function ($q) {
    //     //         $q->where('empStatus', '1');
    //     //     })
    //     //     ->get();
    //     $employees = User::with('empDetail')
    //     ->where('empID', 'KWTGS-0021') // ✅ use the string empID
    //     ->whereHas('empDetail', function ($q) {
    //         $q->where('empStatus', '1');
    //     })
    //     ->get();

    //     $startDate = '2025-10-26';
    //     $endDate   = '2025-11-10';
    //     $paydate   = '2025-11-15';

    //     // 🧹 Delete existing payroll and details for this pay date (clean slate)
    //     Payroll::where('pay_date', $paydate)->delete();
    //     PayrollDetail::where('payroll_date', $paydate)->delete();

    //     foreach ($employees as $emp) {
    //         $salary = $emp->empDetail->getSalaryInfo();
    //         $absentDays       = 0;
    //         $totalHoursWorked = 0;
    //         $totalOT          = 0;
    //         $totalLate        = 0;
    //         $totalUndertime   = 0;

    //         // Get schedules within payroll period
    //         $employeeSchedules = EmployeeSchedule::where('employee_id', $emp->empID)
    //             ->whereBetween('sched_start_date', [$startDate, $endDate])
    //             ->with('attendanceSummaries')
    //             ->get();

                
    //         foreach ($employeeSchedules as $schedule) {
    //             $date = $schedule->sched_start_date;

    //             // Check attendance for this day
    //             $summary = $schedule->attendanceSummaries
    //                 ->where('attendance_date', $date)
    //                 ->first();

    //             // Check leave
    //             // $hasLeave = Leave::where('employee_id', $emp->empID)
    //             //     ->where('leave_date', $date)
    //             //     ->exists();

    //             // // Check OB
    //             // $hasOB = OB::where('employee_id', $emp->empID)
    //             //     ->where('ob_date', $date)
    //             //     ->exists();
    //             $hasOB    = 0;
    //             $hasLeave = 0;

    //             // Absent if no attendance, no leave, no OB
    //             if ((! $summary || $summary->total_hours == 0) && ! $hasLeave && ! $hasOB) {
    //                 $absentDays++;
    //             }

    //             if ($summary) {
    //                 $totalHoursWorked += $summary->total_hours;
    //                 $totalOT          += $summary->ot_hours;
    //                 $totalLate        += $summary->mins_late;
    //                 $totalUndertime   += $summary->mins_undertime;
    //             }
    //         }

    //         // Compute deductions and pay
    //         $allowance  = $salary['allowance'];
    //         $empBasic   = $salary['basic'];
    //         $dailyRate  = $empBasic / 26;
    //         $hourlyRate = $dailyRate / 8;

    //         $regularPay         = ($totalHoursWorked / 8) * $hourlyRate;
    //         $otPay              = $totalOT * ($hourlyRate * 1.25); // OT 25% multiplier
    //         $lateDeduction      = ($totalLate / 60) * $hourlyRate;
    //         $undertimeDeduction = ($totalUndertime / 60) * $hourlyRate;
    //         $absentDeduction    = $absentDays * $dailyRate;

    //         $grossPay = $regularPay + $otPay + $allowance - ($lateDeduction + $undertimeDeduction + $absentDeduction);

    //         // TODO: apply SSS, PhilHealth, Pag-IBIG, BIR, loans
    //         $deductions = $absentDeduction + $lateDeduction + $undertimeDeduction;

    //         $netPay = $grossPay - $deductions;

    //         // Save payroll
    //         $payroll = Payroll::updateOrCreate(
    //             [
    //                 'employee_id'        => $emp->empID,
    //                 'payroll_start_date' => $startDate,
    //                 'payroll_end_date'   => $endDate,
    //                 'basic_salary'       => $empBasic,
    //                 'allowances'         => $allowance,
    //                 'total_deductions'   => $deductions,
    //                 'pay_date'           => $paydate,
    //             ],
    //             [
    //                 'gross_pay' => $grossPay,
    //                 'net_pay'   => $netPay,
    //             ]
    //         );

    //         // Save payroll details
    //         PayrollDetail::updateOrCreate(
    //             [
    //                 'payroll_id'  => $payroll->id,
    //                 'employee_id' => $emp->empID,
    //             ],
    //             [
    //                 'regular_pay'         => $regularPay,
    //                 'ot_pay'              => $otPay,
    //                 'allowance'           => $allowance,
    //                 'late_deduction'      => $lateDeduction,
    //                 'undertime_deduction' => $undertimeDeduction,
    //                 'absent_deduction'    => $absentDeduction,
    //                 'deductions'          => $deductions,
    //                 'net_pay'             => $netPay,
    //                 'payroll_date'        => $paydate,
    //             ]
    //         );
    //     }

    //     return "Payroll computed successfully for pay date $paydate ($startDate to $endDate)";
    // }

    public function computePayroll()
    {
        DB::beginTransaction(); // 🧩 Start transaction

        try {
            // $employees = User::with('empDetail')
            //     ->whereHas('empDetail', function ($q) {
            //         $q->where('empStatus', '1');
            //     })
            //     ->get();
            $employees = User::with('empDetail')
                ->where('empID', 'KWTGS-0021') // ✅ use the string empID
                ->whereHas('empDetail', function ($q) {
                    $q->where('empStatus', '1');
                })
                ->get();

            $startDate = '2025-11-11';
            $endDate   = '2025-11-25';
            $paydate   = '2025-11-30';

            // 🧹 Clean existing data for the same paydate
            $existingPayrolls = Payroll::where('pay_date', $paydate)->get();
            foreach ($existingPayrolls as $oldPayroll) {
                // 1️⃣ Get all loan payments linked to this payroll
                $loanPayments = LoanPayment::where('payroll_id', $oldPayroll->id)->get();

                foreach ($loanPayments as $payment) {
                    $loan = Loan::find($payment->loan_id);

                    if ($loan) {
                        // 2️⃣ Restore previous deducted amount
                        $loan->balance += $payment->amount_paid;

                        // 3️⃣ If previously marked paid, reactivate if balance > 0
                        if ($loan->balance > 0) {
                            $loan->status = 'active';
                        }

                        $loan->save();
                    }

                    // 4️⃣ Delete loan payment record after reversal
                    $payment->delete();
                }

                // 5️⃣ Delete payroll record itself
                $oldPayroll->delete();
            }

            // 6Delete payroll details within range
            PayrollDetail::whereBetween('payroll_date', [$startDate, $endDate])->delete();

            foreach ($employees as $emp) {
                $salary = $emp->empDetail->getSalaryInfo();

                $absentDays       = 0;
                $totalHoursWorked = 0;
                $totalOT          = 0;
                $totalLate        = 0;
                $totalUndertime   = 0;

                $allowance  = $salary['allowance'];
                $empBasic   = $salary['basic'];
                $dailyRate  = $empBasic / 26;
                $hourlyRate = $dailyRate / 8;

                $employeeSchedules = EmployeeSchedule::where('employee_id', $emp->empID)
                    ->whereBetween('sched_start_date', [$startDate, $endDate])
                    ->with('attendanceSummaries')
                    ->get();

                if ($employeeSchedules->isEmpty()) {
                    continue;
                }

                foreach ($employeeSchedules as $schedule) {
                    $schedStart = Carbon::parse($schedule->sched_start_date);
                    $schedEnd   = Carbon::parse($schedule->sched_end_date);

                    for ($date = $schedStart->copy(); $date->lte($schedEnd); $date->addDay()) {
                        $summary = $schedule->attendanceSummaries
                            ->where('attendance_date', $date->format('Y-m-d'))
                            ->first();

                        $hasOB    = 0;
                        $hasLeave = 0;

                        $isAbsent = ((! $summary || $summary->total_hours == 0) && ! $hasLeave && ! $hasOB);
                        if ($isAbsent) {
                            $absentDays++;
                            $logsType = 'Absent';
                        }

                        if ($summary) {
                            $totalHoursWorked += $summary->total_hours;
                            $totalOT          += $summary->ot_hours;
                            $totalLate        += $summary->mins_late;
                            $totalUndertime   += $summary->mins_undertime;
                        }

                        $otPay              = $summary ? $summary->ot_hours * ($hourlyRate * 1.25) : 0;
                        $lateDeduction      = $summary ? ($summary->mins_late / 60) * $hourlyRate : 0;
                        $undertimeDeduction = $summary ? ($summary->mins_undertime / 60) * $hourlyRate : 0;
                        $absentDeduction    = $isAbsent ? $dailyRate : 0;

                        PayrollDetail::updateOrCreate(
                            [
                                'payroll_id'  => null,
                                'employee_id' => $emp->empID,
                                'payroll_date'=> $paydate,
                                'date'        => $schedStart,
                                'logsType'    => $logsType ?? '-',
                            ],
                            []
                        );
                    }
                }

                $regularPay         = ($totalHoursWorked / 8) * $hourlyRate;
                $otPay              = $totalOT;
                $lateDeduction      = ($totalLate / 60) * $hourlyRate;
                $undertimeDeduction = ($totalUndertime / 60) * $hourlyRate;
                $absentDeduction    = $absentDays * $dailyRate;
                $deductions         = $absentDeduction + $lateDeduction + $undertimeDeduction;

                $grossPay = max((($regularPay ?? 0) + ($otPay ?? 0)) - ($deductions ?? 0), 0);

                $previousGross = Payroll::getPreviousGrossIfEndOfMonth(
                    $emp->employee_id,
                    $paydate,
                    $emp->empClassification
                );

                $monthlyGross = 10000; 

                $endDates = Carbon::parse($paydate);
                $isEndOfMonth = $endDates->isSameDay($endDates->copy()->endOfMonth());
                $employeeClass = $emp->empDetail->empClassification;
                $contributions = ContributionHelper::computeAll(
                    $monthlyGross,
                    $employeeClass,
                    $isEndOfMonth,
                    $emp->empID
                );

                $loanDeduction = $contributions['loan_deduction'] ?? 0;
                $govDues = $contributions['sss']['employee_share']
                            + $contributions['philhealth']['employee_share']
                            + $contributions['pagibig']['employee_share']
                            + $contributions['withholding_tax'];

                $netPay = max(0, ($grossPay - $govDues - $loanDeduction) + ($allowance ?? 0));

                $payroll = Payroll::updateOrCreate(
                    [
                        'employee_id'        => $emp->empID,
                        'payroll_start_date' => $startDate,
                        'payroll_end_date'   => $endDate,
                        'basic_salary'       => $empBasic,
                        'allowances'         => $allowance,
                        'total_deductions'   => $deductions,
                        'pay_date'           => $paydate,
                    ],
                    [
                        'gross_pay' => $grossPay,
                        'net_pay'   => $netPay,
                        'sss_contribution' => $contributions['sss']['employee_share'],
                        'philhealth_contribution' => $contributions['philhealth']['employee_share'],
                        'pagibig_contribution' => $contributions['pagibig']['employee_share'],
                        'withholding_tax' => $contributions['withholding_tax'],
                        'sss_loan' => $contributions['loan_breakdown']['sss'] ?? 0,
                        'pagibig_loan' => $contributions['loan_breakdown']['pagibig'] ?? 0,
                        'company_loan' => $contributions['loan_breakdown']['salary'] ?? 0,
                    ]
                );

                if ($isEndOfMonth && $emp->empClassification !== 'TRN') {
                    foreach ($contributions['loan_details'] as $loan) {
                        LoanPayment::create([
                            'loan_id' => $loan['loan_id'],
                            'payroll_id' => $payroll->id,
                            'amount_paid' => $loan['deducted_amount'],
                            'payment_date' => now(),
                            'remarks' => 'Auto payroll deduction',
                        ]);

                        Loan::where('id', $loan['loan_id'])->update([
                            'balance' => $loan['new_balance'],
                            'status'  => $loan['new_balance'] <= 0 ? 'paid' : 'active'
                        ]);
                    }
                }

                PayrollDetail::where('employee_id', $emp->empID)
                    ->whereBetween('payroll_date', [$startDate, $endDate])
                    ->update(['payroll_id' => $payroll->id]);
            }

            DB::commit(); 
            return "Payroll computed successfully for pay date $paydate ($startDate to $endDate)";

        } catch (\Throwable $e) {
            DB::rollBack();

            // 🧠 Log detailed info
            Log::error('Payroll computation failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Return or throw
            return response()->json([
                'status' => 'error',
                'message' => 'Payroll computation failed: '.$e->getMessage(),
            ], 500);
        }
    }

}
