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

    table.table {
        font-size: 0.65rem;
        border-color: #c9c9c9;
    }

    th, td {
        vertical-align: middle !important;
        padding: 4px 6px !important;
        border: 1px solid #d1d1d1 !important;
    }

    thead th {
        font-weight: 500;
        font-size: 0.75rem;
    }

    tbody td {
        font-size: 0.8rem;
    }

    .form-floating label span {
        color: #dc3545;
    }

    .modal-header .btn-close {
        filter: invert(1);
    }
</style>

<div class="container-fluid payroll-container">

    <h4 class="text-gray-800 mb-3">Payroll System</h4>

    <!-- 🔹 Payroll Header & Controls -->
    <div class="row">
        <div class="col-12 px-4">
            <div class="row p-3 border rounded payroll-header">

                <!-- Payroll Date -->
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="fw-bold text-danger">Payroll Date</label>
                    <div class="form-floating mb-2">
                        <input type="date" id="pay_date" name="pay_date" class="form-control" required>
                        <label>Payroll Date <span>*</span></label>
                        <span class="text-danger small error-text pay_date_error"></span>
                    </div>
                    <button class="btn btn-outline-danger w-100 mb-2" id="btnGenerate">Generate</button>
                    <button class="btn btn-secondary w-100" id="btnRelease">Approve for Release</button>
                </div>

                <!-- Cutoff Dates -->
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="fw-bold text-danger">Cut-off Dates</label>
                    <div class="form-floating mb-2">
                        <input type="date" id="date_from" name="date_from" class="form-control" required>
                        <label>Date From <span>*</span></label>
                        <span class="text-danger small error-text date_from_error"></span>
                    </div>
                    <div class="form-floating">
                        <input type="date" id="date_to" name="date_to" class="form-control" required>
                        <label>Date To <span>*</span></label>
                        <span class="text-danger small error-text date_to_error"></span>
                    </div>
                </div>

                <!-- Print & Filter -->
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="fw-bold text-danger">Print & Display Filter</label>
                    <div class="form-floating mb-2">
                        <select id="selFilter" name="filter" class="form-control">
                            <option value="all">All</option>
                            <option value="released">Released</option>
                            <option value="pending">Pending</option>
                        </select>
                        <label>Payroll Filter <span>*</span></label>
                        <span class="text-danger small error-text filter_error"></span>
                    </div>
                    <button class="btn btn-danger w-100 mb-2" id="btnPrint">Print</button>
                    <div class="d-flex gap-2">
                        <button class="btn btn-secondary flex-fill" id="btnPayroll">Payroll</button>
                        <button class="btn btn-secondary flex-fill" id="btnSummary">Summary</button>
                    </div>
                </div>

                <!-- Adjustment -->
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="fw-bold text-danger">Adjustment</label>
                    <button class="btn btn-secondary w-100 mt-1" data-bs-toggle="modal" data-bs-target="#mdlAdjustment" id="btnAdjustment">
                        <i class="fa fa-plus"></i> Adjustment
                    </button>
                </div>
            </div>

            <!-- 🔹 Payroll Table -->
            <div class="row pt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2">#</th>
                                <th rowspan="2">Employee Name</th>
                                <th rowspan="2">Monthly Rate</th>
                                <th rowspan="2">Bi-Monthly Rate</th>
                                <th rowspan="2">Total Allowances<br>(Bi-Monthly)</th>
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const printBtn = document.getElementById('btnPrint');

        printBtn.addEventListener('click', function () {
            const table = document.querySelector('.table-responsive').innerHTML;

            // ✅ Get input values
            const payDate = document.getElementById('pay_date').value || 'N/A';
            const dateFrom = document.getElementById('date_from').value || 'N/A';
            const dateTo = document.getElementById('date_to').value || 'N/A';

            // ✅ Get current date and time
            const now = new Date();
            const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            const generatedAt = now.toLocaleString('en-US', options);

            // ✅ Get current logged-in user name (Laravel)
            const generatedBy = `{{ Auth::user()->fname ?? '' }} {{ Auth::user()->lname ?? '' }}`;

            // ✅ Open print window
            const printWindow = window.open('', '', 'width=1200,height=800');
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Payroll Report</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                color: #000;
                                padding: 20px;
                            }
                            h2, h4 {
                                text-align: center;
                                margin: 0;
                            }
                            h2 {
                                font-weight: bold;
                                margin-bottom: 5px;
                            }
                            .report-header {
                                margin-bottom: 15px;
                                border-bottom: 1px solid #ccc;
                                padding-bottom: 10px;
                            }
                            .report-meta {
                                margin-top: 10px;
                                font-size: 0.85rem;
                            }
                            table {
                                width: 100%;
                                border-collapse: collapse;
                                font-size: 0.75rem;
                                margin-top: 15px;
                            }
                            th, td {
                                border: 1px solid #888;
                                padding: 5px 8px;
                                text-align: center;
                            }
                            thead th {
                                background-color: #f2f2f2;
                            }
                            .footer {
                                margin-top: 30px;
                                font-size: 0.8rem;
                                text-align: right;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="report-header">
                            <h2>Payroll Report</h2>
                            <h4>Payroll Period: ${dateFrom} to ${dateTo}</h4>
                            <div class="report-meta">
                                <strong>Payroll Date:</strong> ${payDate} <br>
                                <strong>Generated By:</strong> ${generatedBy} <br>
                                <strong>Generated On:</strong> ${generatedAt}
                            </div>
                        </div>
                        ${table}
                        <div class="footer">
                            <i>Generated from Payroll System</i>
                        </div>
                    </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        });
    });
</script>
@endsection
