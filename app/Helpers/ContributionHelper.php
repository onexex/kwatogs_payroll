<?php

namespace App\Helpers;

use App\Models\SSSContribution;
use App\Models\PhilhealthContribution;
use App\Models\PagibigContribution;
use App\Models\BirWithholdingTax;
use App\Models\Loan;
use App\Models\LoanPayment;

class ContributionHelper
{
    public static function computeAll($monthlyGross, $employeeClass, $isEndOfMonth = false,$employeeId = null)
    {
        // If NOT end of month or employee is trainee → no deductions
        if (!$isEndOfMonth || $employeeClass === 'TRN') {
            return [
                'sss' => ['employee_share' => 0, 'employer_share' => 0, 'total' => 0],
                'philhealth' => ['employee_share' => 0, 'employer_share' => 0, 'total' => 0],
                'pagibig' => ['employee_share' => 0, 'employer_share' => 0, 'total' => 0],
                'withholding_tax' => 0,
            ];
        }

        // Compute all deductions normally
        $sss = SSSContribution::compute($monthlyGross, $employeeClass);
        $philhealth = PhilhealthContribution::compute($monthlyGross, $employeeClass);
        $pagibig = PagibigContribution::compute($monthlyGross, $employeeClass);

        // Compute taxable income
        $taxableIncome = $monthlyGross
            - ($sss['employee_share'] ?? 0)
            - ($philhealth['employee_share'] ?? 0)
            - ($pagibig['employee_share'] ?? 0);

        // Compute withholding tax
        $withholdingTax = BirWithholdingTax::compute($taxableIncome, $employeeClass);

        // Default loan values
        $loanDeduction = 0;

        // Track deductions *per loan type*
        $loanBreakdown = [
            'pagibig'    => 0,
            'sss'        => 0,
            'philhealth' => 0,
            'salary'     => 0,
        ];

        $loanDetails = []; // for updating balances later

        // Apply loan only at end of month & employee not trainee
        if ($isEndOfMonth && $employeeClass !== 'TRN' && $employeeId) {

            // Get all active loans with remaining balance
            $loans = Loan::where('employee_id', $employeeId)
                ->where('status', 'active')
                ->where('balance', '>', 0)
                ->get();

            foreach ($loans as $loan) {

                $amount = min($loan->monthly_amortization, $loan->balance);
                $loanDeduction += $amount;

                // ✅ Identify loan type
                switch ($loan->loan_type) {
                    case 'pagibig':
                        $loanBreakdown['pagibig'] += $amount;
                        break;

                    case 'sss':
                        $loanBreakdown['sss'] += $amount;
                        break;

                    case 'philhealth':
                        $loanBreakdown['philhealth'] += $amount;
                        break;

                    case 'salary':
                        $loanBreakdown['salary'] += $amount;
                        break;
                }

                // Store details for updating loan balance later
                $loanDetails[] = [
                    'loan_id' => $loan->id,
                    'deducted_amount' => $amount,
                    'new_balance' => $loan->balance - $amount,
                ];
            }
        }

        return [
            'sss' => $sss,
            'philhealth' => $philhealth,
            'pagibig' => $pagibig,
            'withholding_tax' => $withholdingTax,

            'loan_deduction' => $loanDeduction,
            'loan_breakdown' => $loanBreakdown, // ✅ categorized amounts
            'loan_details'   => $loanDetails,   // ✅ for updating loan balances
        ];
    }
}
