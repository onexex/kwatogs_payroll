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
use App\Models\holidayLoggerModel;
use Illuminate\Http\Request;
 


class PayrollController extends Controller
{

    // public function computePayroll()
    // {
    //     DB::beginTransaction(); // 🧩 Start transaction

    //     try {
    //         // $employees = User::with('empDetail')
    //         //     ->whereHas('empDetail', function ($q) {
    //         //         $q->where('empStatus', '1');
    //         //     })
    //         //     ->get();
    //         $employees = User::with('empDetail')
    //             ->where('empID', 'KWTGS-0021')  
    //             ->whereHas('empDetail', function ($q) {
    //                 $q->where('empStatus', '1');
    //             })
    //             ->get();
    //         $startDate = '2025-11-11';
    //         $endDate   = '2025-11-25';
    //         $paydate   = '2025-11-30';

    //         // Clean existing data for the same paydate
    //         $existingPayrolls = Payroll::where('pay_date', $paydate)->get();
    //         foreach ($existingPayrolls as $oldPayroll) {
    //             $loanPayments = LoanPayment::where('payroll_id', $oldPayroll->id)->get();
    //             foreach ($loanPayments as $payment) {
    //                 $loan = Loan::find($payment->loan_id);
    //                 if ($loan) {
    //                     $loan->balance += $payment->amount_paid;
    //                     if ($loan->balance > 0) {
    //                         $loan->status = 'active';
    //                     }
    //                     $loan->save();
    //                 }
    //                 $payment->delete();
    //             }
    //             $oldPayroll->delete();
    //         }

    //         // Delete payroll details within range
    //         PayrollDetail::where('payroll_date', $paydate)->delete();

    //         $holidays = holidayLoggerModel::whereBetween('date', [$startDate, $endDate])->get();
    //         $holidayDates = $holidays->mapWithKeys(function ($holiday) {
    //             return [date('Y-m-d', strtotime($holiday->date)) => $holiday->type];
    //         })->toArray();

    //         foreach ($employees as $emp) {
    //             $salary = $emp->empDetail->getSalaryInfo();
    //             $absentDays       = 0;
    //             $totalHoursWorked = 0;
    //             $totalOT          = 0;
    //             $totalLate        = 0;
    //             $totalUndertime   = 0;
    //             $holidayPay       = 0; // Holiday pay accumulator
    //             $regularPayifNodedction = 0;

    //             $allowance  = $salary['allowance'] / 2;
    //             $empBasic   = $salary['basic'];
    //             $dailyRate  = $empBasic / 26;
    //             $hourlyRate = $dailyRate / 8;
        
    //             $employeeSchedules = EmployeeSchedule::where('employee_id', $emp->empID)
    //                 ->whereBetween('sched_start_date', [$startDate, $endDate])
    //                 ->with('attendanceSummaries')
    //                 ->get();
              
    //             if ($employeeSchedules->isEmpty()) continue;

    //             // Index all attendance summaries once per employee
    //             $attendanceSummaries = $emp->attendanceSummaries()
    //                 ->whereBetween('attendance_date', [$startDate, $endDate])
    //                 ->get()
    //                 ->keyBy(function ($summary) {
    //                     return date('Y-m-d', strtotime($summary->attendance_date));
    //                 });

    //             foreach ($employeeSchedules as $schedule) {
    //                 $schedStart = Carbon::parse($schedule->sched_start_date);
    //                 $schedEnd   = Carbon::parse($schedule->sched_end_date);

    //                 for ($date = $schedStart->copy(); $date->lte($schedEnd); $date->addDay()) {
    //                     $dateStr = $date->format('Y-m-d');
    //                     $summary = $attendanceSummaries[$dateStr] ?? null;
    //                     $hasOB    = 0;
    //                     $hasLeave = 0;
    //                     $isAbsent = ((! $summary || $summary->total_hours == 0) && ! $hasLeave && ! $hasOB);
    //                     if ($isAbsent) {
    //                         $absentDays++;
    //                         $logsType = 'Absent';
    //                     }

    //                     if ($summary) {
    //                         $totalHoursWorked += $summary->total_hours;
    //                         $totalOT          += $summary->ot_hours;
    //                         $totalLate        += $summary->mins_late;
    //                         $totalUndertime   += $summary->mins_undertime;
    //                     }
                 
    //                     //  Holiday pay calculation 
    //                     if (array_key_exists($dateStr, $holidayDates)) {
    //                         $holidayType = $holidayDates[$dateStr];
    //                         $worked      = $summary && $summary->total_hours > 0;
                           
    //                         $prevDay = $date->copy()->subDay()->format('Y-m-d');
    //                         $nextDay = $date->copy()->addDay()->format('Y-m-d');
                      
    //                         $presentBefore = isset($attendanceSummaries[$prevDay]) && $attendanceSummaries[$prevDay]->total_hours > 0;
    //                         // $presentAfter  = isset($attendanceSummaries[$nextDay]) && $attendanceSummaries[$nextDay]->total_hours > 0;
                           
    //                         if ($holidayType == '1') {
    //                             if ($worked) {
    //                                 $holidayPay += $dailyRate * 2; // 200%
    //                             // } elseif ($presentBefore || $presentAfter) {
    //                             } elseif ($presentBefore) {
    //                                 $holidayPay += $dailyRate; // 100%
    //                             }
    //                         } elseif ($holidayType == '0') {
    //                             if ($worked) {
    //                                 $holidayPay += $dailyRate * 1.3; // 130%
    //                             }
    //                         }
    //                     }

    //                     PayrollDetail::updateOrCreate(
    //                         [
    //                             'payroll_id'  => null,
    //                             'employee_id' => $emp->empID,
    //                             'payroll_date'=> $paydate,
    //                             'date'        => $dateStr,
    //                             'logsType'    => $logsType ?? '-',
    //                         ],
    //                         []
    //                     );
    //                 }
    //             }

    //             $employeeClass = $emp->empDetail->empClassification;
    //             $regularPay         = ($totalHoursWorked * $hourlyRate);
    //             $otPay              = $totalOT;
    //             $lateDeduction      = ($totalLate / 60) * $hourlyRate;
    //             $undertimeDeduction = ($totalUndertime / 60) * $hourlyRate;
    //             $absentDeduction    = $absentDays * $dailyRate;
    //             $deductions         = $absentDeduction + $lateDeduction + $undertimeDeduction;
    //             // $regularPayifNoDeduction = $dailyRate * $employeeSchedules->count();
              
    //             // Include holiday pay
    //             $grossPay = max((($regularPay ?? 0) + ($otPay ?? 0) + $holidayPay), 0);
    //             $previousGross = Payroll::getPreviousGrossIfEndOfMonth(
    //                 $emp->employee_id,
    //                 $paydate,
    //                 $emp->empClassification
    //             );

    //             $monthlyGross = 10000 + $grossPay; 
    //             $endDates = Carbon::parse($paydate);
    //             $isEndOfMonth = $endDates->isSameDay($endDates->copy()->endOfMonth());
                
    //             $contributions = ContributionHelper::computeAll(
    //                 $monthlyGross,
    //                 $employeeClass,
    //                 $isEndOfMonth,
    //                 $emp->empID
    //             );

    //             $salaryLoan = $contributions['loan_breakdown']['salary'] ?? 0;
    //             $govDues = $contributions['sss']['employee_share']
    //                         + $contributions['philhealth']['employee_share']
    //                         + $contributions['pagibig']['employee_share']
    //                         + $contributions['withholding_tax'];

    //             $netPay = max(0, ($grossPay - $govDues - $salaryLoan) + ($allowance ?? 0));
         
    //             $payroll = Payroll::updateOrCreate(
    //                 [
    //                     'employee_id'        => $emp->empID,
    //                     'payroll_start_date' => $startDate, 
    //                     'payroll_end_date'   => $endDate,
    //                     'basic_salary'       => $empBasic,
    //                     'allowances'         => $allowance,
    //                     'total_deductions'   => $deductions,
    //                     'pay_date'           => $paydate,
                        
    //                 ],
    //                 [
    //                     'gross_pay' => $grossPay,
    //                     'net_pay'   => $netPay,
    //                     'sss_contribution' => $contributions['sss']['employee_share'],
    //                     'philhealth_contribution' => $contributions['philhealth']['employee_share'],
    //                     'pagibig_contribution' => $contributions['pagibig']['employee_share'],
    //                     'withholding_tax' => $contributions['withholding_tax'],
    //                     'sss_loan' => $contributions['loan_breakdown']['sss'] ?? 0,
    //                     'pagibig_loan' => $contributions['loan_breakdown']['pagibig'] ?? 0,
    //                     'company_loan' => $contributions['loan_breakdown']['salary'] ?? 0,
    //                     'sss_employer' => $contributions['sss']['employer_share'],
    //                     'philhealth_employer' => $contributions['philhealth']['employer_share'],
    //                     'pagibig_employer'=> $contributions['pagibig']['employer_share'],
 
    //                 ]
    //             );
           
    //             if ($isEndOfMonth && $emp->empClassification !== 'TRN') {
    //                 foreach ($contributions['loan_details'] as $loan) {
    //                     LoanPayment::create([
    //                         'loan_id' => $loan['loan_id'],
    //                         'payroll_id' => $payroll->id,
    //                         'amount_paid' => $loan['deducted_amount'],
    //                         'payment_date' => now(),
    //                         'remarks' => 'Auto payroll deduction',
    //                     ]);

    //                     Loan::where('id', $loan['loan_id'])->update([
    //                         'balance' => $loan['new_balance'],
    //                         'status'  => $loan['new_balance'] <= 0 ? 'paid' : 'active'
    //                     ]);
    //                 }
    //             }
                
    //         $updatedRows = PayrollDetail::where('employee_id', $emp->empID)
    //             ->whereBetween('date', [$startDate, $endDate])
    //             ->update(['payroll_id' => $payroll->id]);
    //         }
    //         DB::commit(); 
    //         return " Gross  $monthlyGross Payroll computed successfully for pay date $paydate ($startDate to $endDate)";
    //     } catch (\Throwable $e) {
    //         DB::rollBack();

    //         // Log detailed info
    //         Log::error('Payroll computation failed', [
    //             'message' => $e->getMessage(),
    //             'line' => $e->getLine(),
    //             'file' => $e->getFile(),
    //             'trace' => $e->getTraceAsString(),
    //         ]);

    //         // Return or throw
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Payroll computation failed: '.$e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function fetchPayroll(Request $request)
    {
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');
        $filter = $request->query('filter', 'all'); // optional filter: all, released, pending

        $query = Payroll::with('employee'); // eager load employee info

        if ($dateFrom && $dateTo) {
            $query->where('pay_date',$pay_date);
        }

        if ($filter !== 'all') {
            $query->where('status', $filter);
        }

        $payrolls = $query->orderBy('pay_date', 'desc')->get();

        return response()->json($payrolls);
    }

    public function computePayroll()
    {
        DB::beginTransaction();

        try {
            $employees = User::with('empDetail')
                ->where('empID', 'KWTGS-0021')
                ->whereHas('empDetail', function ($q) {
                    $q->where('empStatus', '1');
                })
                ->get();

            $startDate = '2025-11-11';
            $endDate   = '2025-11-25';
            $paydate   = '2025-11-30';

            // 🔄 Clean old payroll for same paydate
            $existingPayrolls = Payroll::where('pay_date', $paydate)->get();
            foreach ($existingPayrolls as $oldPayroll) {
                $loanPayments = LoanPayment::where('payroll_id', $oldPayroll->id)->get();
                foreach ($loanPayments as $payment) {
                    $loan = Loan::find($payment->loan_id);
                    if ($loan) {
                        $loan->balance += $payment->amount_paid;
                        if ($loan->balance > 0) $loan->status = 'active';
                        $loan->save();
                    }
                    $payment->delete();
                }
                $oldPayroll->delete();
            }
            PayrollDetail::where('payroll_date', $paydate)->delete();

            // 🎌 Load holidays
            $holidays = holidayLoggerModel::whereBetween('date', [$startDate, $endDate])->get();
            $holidayDates = $holidays->mapWithKeys(fn($holiday) => [
                date('Y-m-d', strtotime($holiday->date)) => $holiday->type
            ])->toArray();

            foreach ($employees as $emp) {
                $salary = $emp->empDetail->getSalaryInfo();
                $empBasic   = $salary['basic'];
                $allowance  = $salary['allowance'] / 2;
                $dailyRate  = $empBasic / 26;
                $hourlyRate = $dailyRate / 8;

                $absentDays = 0;
                $totalHoursWorked = 0;
                $totalOT = 0;
                $totalLate = 0;
                $totalUndertime = 0;
                $holidayPay = 0;
                $basicPay=0;


                $employeeSchedules = EmployeeSchedule::where('employee_id', $emp->empID)
                    ->whereBetween('sched_start_date', [$startDate, $endDate])
                    ->with('attendanceSummaries')
                    ->get();

                if ($employeeSchedules->isEmpty()) continue;

                $attendanceSummaries = $emp->attendanceSummaries()
                    ->whereBetween('attendance_date', [$startDate, $endDate])
                    ->get()
                    ->keyBy(fn($s) => date('Y-m-d', strtotime($s->attendance_date)));

                foreach ($employeeSchedules as $schedule) {
                    $schedStart = Carbon::parse($schedule->sched_start_date);
                    $schedEnd   = Carbon::parse($schedule->sched_end_date);

                    for ($date = $schedStart->copy(); $date->lte($schedEnd); $date->addDay()) {
                        $dateStr = $date->format('Y-m-d');
                        $summary = $attendanceSummaries[$dateStr] ?? null;

                        $isAbsent = (!$summary || $summary->total_hours == 0);
                        if ($isAbsent) $absentDays++;

                        if ($summary) {
                            $totalHoursWorked += $summary->total_hours;
                            $totalOT          += $summary->ot_hours;
                            $totalLate        += $summary->mins_late;
                            $totalUndertime   += $summary->mins_undertime;
                        }

                        // Holiday pay
                        if (array_key_exists($dateStr, $holidayDates)) {
                            $holidayType = $holidayDates[$dateStr];
                            $worked = $summary && $summary->total_hours > 0;
                            $prevDay = $date->copy()->subDay()->format('Y-m-d');
                            $presentBefore = isset($attendanceSummaries[$prevDay]) && $attendanceSummaries[$prevDay]->total_hours > 0;
                           
                            if ($holidayType == '1') {
                                if ($worked){
                                    $holidayPay += $dailyRate * 1;
                                } 
                                elseif ($presentBefore){
                                     $holidayPay += $dailyRate;
                                    $absentDays=$absentDays-1;
                                } 
                            } elseif ($holidayType == '0' && $worked) {
                                $holidayPay += $dailyRate * .3;
                            } 
                        }

                        PayrollDetail::updateOrCreate(
                            [
                                'payroll_id'  => null,
                                'employee_id' => $emp->empID,
                                'payroll_date'=> $paydate,
                                'date'        => $dateStr,
                                'logsType'    => $isAbsent ? 'Absent' : 'Present',
                            ],
                            []
                        );
                    }
                }

                // ======================
                //  REGULAR vs DAILY
                // ======================
                $employeeClass = $emp->empDetail->empClassification;

                if ($employeeClass === 'RGLR') {
                    //  Monthly payroll
                    $basicPay=$empBasic /2;
                    $absentDeduction    = $absentDays * $dailyRate;
                    $lateDeduction      = ($totalLate / 60) * $hourlyRate;
                    $undertimeDeduction = ($totalUndertime / 60) * $hourlyRate;
                    $deductions = $absentDeduction + $lateDeduction + $undertimeDeduction; //overbrake time passout
                    $grossPay = $empBasic - $deductions + $holidayPay + $allowance;
                    $monthlyGross = $grossPay;
                } else {
                     
                    //  Daily / Non-Regular payroll
                    $basicPay= $dailyRate;
                    $regularPay   = $totalHoursWorked * $hourlyRate;
                    $otPay        = $totalOT;
                    $absentDeduction    = $absentDays * $dailyRate;
                    $lateDeduction      = ($totalLate / 60) * $hourlyRate;
                    $undertimeDeduction = ($totalUndertime / 60) * $hourlyRate;
                    $deductions = $absentDeduction + $lateDeduction + $undertimeDeduction;
                    $grossPay = max(($regularPay + $otPay + $holidayPay), 0);
                    $monthlyGross = $grossPay;
                }
         
                // ======================
                //  CONTRIBUTIONS
                // ======================
                $isEndOfMonth = Carbon::parse($paydate)->isSameDay(Carbon::parse($paydate)->endOfMonth());
                $contributions = ContributionHelper::computeAll(
                    $monthlyGross,
                    $employeeClass,
                    $isEndOfMonth,
                    $emp->empID
                );

                $salaryLoan = $contributions['loan_breakdown']['salary'] ?? 0;
                $charges = $contributions['loan_breakdown']['salary'] ?? 0;
                $salaryLoan = $contributions['loan_breakdown']['salary'] ?? 0;
                $taxable_income = $contributions['taxable_income'];
           
                $govDues = 
                $contributions['sss']['employee_share']
                    + $contributions['philhealth']['employee_share']
                    + $contributions['pagibig']['employee_share']
                    + $contributions['withholding_tax'];

                $netPay = max(0, ($grossPay - $govDues - $salaryLoan  + $allowance));

                // ======================
                //  SAVE PAYROLL
                // ======================
                $payroll = Payroll::updateOrCreate(
                    [
                        'employee_id'        => $emp->empID,
                        'payroll_start_date' => $startDate,
                        'payroll_end_date'   => $endDate,
                        'pay_date'           => $paydate,
                    ],
                    [
                        'basic_salary' => $empBasic,
                        'basicPay' => $basicPay,
                        //-
                        'total_deductions' => $deductions,
                        //+ot
                        'gross_pay'    => $grossPay,
                        //-
                        'sss_contribution' => $contributions['sss']['employee_share'],
                        'philhealth_contribution' => $contributions['philhealth']['employee_share'],
                        'pagibig_contribution' => $contributions['pagibig']['employee_share'],
                        'sss_loan' => $contributions['loan_breakdown']['sss'] ?? 0,
                        'pagibig_loan' => $contributions['loan_breakdown']['pagibig'] ?? 0,
                        //=
                        'taxable_income'=>  $taxable_income,
                        //-
                        'withholding_tax' => $contributions['withholding_tax'],
                        'allowances'   => $allowance,
                        'net_pay'      => $netPay,
                        'holiday_pay'=>$holidayPay,
                        'company_loan' => $contributions['loan_breakdown']['salary'] ?? 0,
                        'sss_employer' => $contributions['sss']['employer_share'],
                        'philhealth_employer' => $contributions['philhealth']['employer_share'],
                        'pagibig_employer'=> $contributions['pagibig']['employer_share'],
                        'penalty_amount'=> $contributions['loan_breakdown']['charges/penalty'],

                    ]
                );

                //  Auto loan deduction if end of month
                if ($isEndOfMonth && $employeeClass !== 'TRN') {
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

                //  Update payroll details
                PayrollDetail::where('employee_id', $emp->empID)
                    ->whereBetween('date', [$startDate, $endDate])
                    ->update(['payroll_id' => $payroll->id]);
            }

            DB::commit();
            return "Payroll computed successfully for pay date $paydate ($startDate to $endDate)";
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Payroll computation failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Payroll computation failed: '.$e->getMessage(),
            ], 500);
        }
    }

}
