@extends('layout.app')

@section('content')
<style>
    /* Payroll Page Styling */
    .payroll-container h4 {
        font-weight: 400;
        margin-bottom: 1rem;
            }

            .payroll-header {
                background-color: #ff00000a !important;
            }

            .table-responsive {
            overflow-x: auto;
            margin-bottom: 1rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.65rem;
            color: #333;
        }

        .table th, .table td {
            padding: 4px 6px;
            text-align: center;
            border: 1px solid #ddd;
            white-space: nowrap;
        }

        .table thead th {
            background-color: #f8f9fa;
            font-weight: 500;
            font-size: 0.7rem;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Sticky headers */
        .table-responsive thead th {
            position: sticky;
            top: 0;
            z-index: 2;
        }

        /* Format numbers in JS, see previous function */

        /* ===== Mobile view ===== */
        @media (max-width: 768px) {
            .table thead {
                display: none; /* hide headers */
            }
            .table, .table tbody, .table tr, .table td {
                display: block;
                width: 100%;
            }
            .table tr {
                margin-bottom: 1rem;
                border: 1px solid #ccc;
                border-radius: 6px;
                padding: 8px;
                background-color: #fff;
            }
            .table td {
                text-align: left;
                padding: 4px 8px;
                border: none;
                position: relative;
                padding-left: 45%;
            }
            .table td::before {
                position: absolute;
                left: 10px;
                width: 40%;
                white-space: nowrap;
                font-weight: 500;
                content: attr(data-label);
            }
        }
            .form-floating label span {
                color: #dc3545;
            }

            .modal-header .btn-close {
                filter: invert(1);
            }

        .card input.form-control:focus {
                border-color: #008080;
                box-shadow: 0 0 0 0.2rem rgba(0,128,128,0.25);
            }
            .card select.form-select:focus {
                border-color: #008080;
                box-shadow: 0 0 0 0.2rem rgba(0,128,128,0.25);
            }
            .btn-outline-secondary:hover {
                background-color: #008080;
                color: #fff;
                border-color: #008080;
            }
</style>

<div class="container-fluid payroll-container">

    <h4 class="text-gray-800 mb-3">Payroll System</h4>
    <!-- 🔹 Payroll Header & Controls -->
    <div class="row">
        <div class="col-12 px-4">
            <div class="row g-3 mb-3">
    <!-- Payroll Date Card -->
 <div class="col-lg-3 col-md-6">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3 ">
                <i class="fa fa-calendar fa-lg me-2" style="color:#008080;"></i>
                <h6 class="mb-0 fw-bold" style="color:#008080;">Payroll Date</h6>
            </div>
<input type="date" id="pay_date" class="form-control mb-2" value="2025-10-31" required>

            <div class="d-flex gap-2 ">
                <button class="btn" id="btnGenerate" style="background-color:#008080;color:#fff; flex:1;">Generate</button>
                <button class="btn btn-secondary" id="btnRelease" style="flex:1;">Approve for Release</button>
            </div>
        </div>
    </div>
</div>

    <!-- Cutoff Dates Card -->
    <div class="col-lg-3 col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <i class="fa fa-clock-o fa-lg me-2" style="color:#008080;"></i>
                    <h6 class="mb-0 fw-bold" style="color:#008080;">Cut-off Dates</h6>
                </div>
                <input type="date" id="date_from" class="form-control mb-2" required placeholder="Date From">
                <input type="date" id="date_to" class="form-control mb-2" required placeholder="Date To">
            </div>
        </div>
    </div>

    <!-- Print & Filter Card -->
    <div class="col-lg-3 col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <i class="fa fa-print fa-lg me-2" style="color:#008080;"></i>
                    <h6 class="mb-0 fw-bold" style="color:#008080;">Print & Filter</h6>
                </div>
                <select id="selFilter" class="form-select mb-2">
                    <option value="all">All</option>
                    <option value="released">Released</option>
                    <option value="pending">Pending</option>
                </select>
                <div class="d-grid gap-2">
                  
                    <div class="d-flex gap-2 mt-2">
                        <button class="btn btn-outline-secondary flex-fill" id="btnPayroll">Payroll</button>
                        <button class="btn btn-outline-secondary flex-fill" id="btnSummary">Summary</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Adjustment Card -->
    <div class="col-lg-3 col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                <i class="fa fa-plus-circle fa-2x mb-2" style="color:#008080;"></i>
                <h6 class="mb-2 fw-bold" style="color:#008080;">Adjustment</h6>
                <button class="btn btn-outline-secondary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#mdlAdjustment" id="btnAdjustment">
                    Add Adjustment
                </button>
            </div>
        </div>
    </div>
</div>


            <!-- 🔹 Payroll Table -->
            <div class="row card pt-3">
                <!-- Payroll Table Controls -->
                <div class="d-flex justify-content-start mb-2">
                    <button class="btn" id="btnPrint" style="background-color:#008080;color:#fff;">
                        <i class="fa fa-print me-1"></i> Print
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        {{-- <thead class="table-light">
                            <tr>
                                <th rowspan="2">#</th>
                                <th rowspan="2">Employee Name</th>
                                <th rowspan="2">Monthly Salary</th>
                                <th rowspan="2">Bi-Monthly Rate</th>
                                <th rowspan="2">Allowances<br>(Bi-Monthly)</th>
                                <th colspan="6">Earnings</th>
                                <th rowspan="2">Total Working Days</th>
                                <th rowspan="2">Total Allowance</th>
                                <th rowspan="2">Adjustment</th>
                                <th rowspan="2">Gross Pay</th>
                                <th colspan="2">Tardiness</th>
                                <th colspan="2">Leave W/O Pay</th>
                                <th colspan="3">Government Premiums</th>
                                <th rowspan="2">Charges / Penalties</th>
                                <th rowspan="2">Cash Advance</th>
                                <th rowspan="2">Cash Advance Balance</th>
                                <th rowspan="2">Total Deductions</th>
                                <th rowspan="2">Net Pay</th>
                            </tr>
                            <tr>
                                <th>Reg. Working Day</th>
                                <th>Reg. Day OT (Hour)</th>
                                <th>Reg. Day OT (Amount)</th>
                                <th>Night Diff. (Hrs)</th>
                                <th>Night Diff. (Amount)</th>
                                <th>Other Earnings</th>
                                <th>Hrs</th>
                                <th>Amount</th>
                                <th>Day</th>
                                <th>Amount</th>
                                <th>SSS</th>
                                <th>PHIC</th>
                                <th>PAG-IBIG</th>
                            </tr>
                        </thead> --}}

                          <thead class="table-light">
                            <tr>
                                <th rowspan="2">#</th>
                                <th rowspan="2" class="text-uppercase">Employee Name</th>
                                <th rowspan="2" class="text-uppercase">Monthly Salary</th>
                                <th rowspan="2" class="text-uppercase">Bi-Monthly Rate</th>
                                {{-- <th rowspan="2">Allowances<br>(Bi-Monthly)</th> --}}
                                <th rowspan="2" class="text-uppercase">ABS/TRD/UT/TPO/OB DED</th>
                                <th colspan="3" class="text-uppercase">Earnings</th>
                               
                                {{-- <th rowspan="2">Total Allowance</th> --}}
                                {{-- <th rowspan="2">Adjustment</th> --}}
                                <th rowspan="2" class="text-uppercase">GROSS PAY</th>
                                <th colspan="5" class="text-uppercase">Government Premiums/Loan</th>
                                <th rowspan="2" class="text-uppercase">TI</th>
                                <th rowspan="2" class="text-uppercase">Tax</th>
                                <th rowspan="2" class="text-uppercase">N PAY</th>
                                <th rowspan="2" class="text-uppercase">Allowance</th>
                                <th rowspan="2" class="text-uppercase">Adjustment</th>
                                
                                {{-- <th colspan="2">Tardiness</th> --}}
                                {{-- <th colspan="2">Leave W/O Pay</th> --}}
                              
                                <th rowspan="2" class="text-uppercase">Charges / Penalties</th>
                                <th rowspan="2" class="text-uppercase">Cash Advance</th>
                                {{-- <th rowspan="2" class="text-uppercase">Cash Advance Balance</th>
                                <th rowspan="2" class="text-uppercase">Total Deductions</th> --}}
                                <th rowspan="2" class="text-uppercase">PAY Receivable</th>
                            </tr>
                            <tr>
                                <th>HD PAY</th>
                                <th>OT PAY</th>
                                <th>ND PAY</th>
                            
                                <th>SSS </th>
                                <th>SSS LOAN</th>
                                <th>PAGIBIG</th>
                                <th>PAGIBIG LOAN</th>
                                <th>PHILHEALTH</th>
                            </tr>

                        </thead>
                        <tbody id="payrollTableBody">
                            <!-- Dynamic rows go here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔹 Adjustment Modal -->
    <div class="modal fade" id="mdlAdjustment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="mdlAdjustmentLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="mdlAdjustmentLabel">Payroll Adjustment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="card rounded mb-3">
                        <div class="card-body">
                            <div class="row g-3 align-items-end">
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-floating">
                                        <select id="selEmployee" name="employee" class="form-control">
                                            <option value="">-- Select Employee --</option>
                                            {{-- @foreach ($employees as $emp)
                                                <option value="{{ $emp->id }}">{{ $emp->fullname }}</option>
                                            @endforeach --}}
                                        </select>
                                        <label>Employee <span>*</span></label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-floating">
                                        <input type="number" step="0.01" id="txtAmount" name="amount" class="form-control">
                                        <label>Adjustment Amount <span>*</span></label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <button class="btn btn-secondary w-100" id="btnSaveAdjustment">
                                        <i class="fa fa-save"></i> Save Adjustment
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive mt-4">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Employee</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblAdjustment">
                                        <!-- Dynamic adjustment rows -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="btnSaveClassification" class="btn btn-danger">Save Entries</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="{{ asset('js/modules/payroll.js') }}"></script>


@endsection
