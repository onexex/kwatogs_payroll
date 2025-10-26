@extends('layout.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between">
        <h3>Loan Management</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loanModal" id="addLoanBtn">
            Add Loan
        </button>
    </div>

    <table class="table table-bordered mt-3 shadow-sm">
         <thead style=" background-color: #f1f1f1;"  >
            <tr>
                <th>Employee</th>
                <th>Type</th>
                <th>Loan Amount</th>
                <th>Balance</th>
                <th>Monthly Amortization</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th width="120">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($loans as $loan)
            <tr>
                <td>{{ $loan->employee->fname }}</td>
                <td>{{ $loan->loan_type }}</td>
                <td>{{ number_format($loan->loan_amount, 2) }}</td>
                <td>{{ number_format($loan->balance, 2) }}</td>
                <td>{{ number_format($loan->monthly_amortization, 2) }}</td>
                <td>{{ $loan->start_date }}</td>
                <td>{{ $loan->end_date }}</td>
                <td>{{ $loan->status }}</td>
                <td>
                    <button class="btn btn-sm btn-warning editLoanBtn"
                        data-id="{{ $loan->id }}"
                        data-employee="{{ $loan->employee_id }}"
                        data-type="{{ $loan->loan_type }}"
                        data-amount="{{ $loan->loan_amount }}"
                        data-balance="{{ $loan->balance }}"
                        data-amort="{{ $loan->monthly_amortization }}"
                        data-start="{{ $loan->start_date }}"
                        data-end="{{ $loan->end_date }}"
                        data-status="{{ $loan->status }}">
                        Edit
                    </button>
                    <button class="btn btn-sm btn-danger deleteLoanBtn" data-id="{{ $loan->id }}">
                        Delete
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


<!-- Modal -->
<div class="modal fade" id="loanModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalTitle">Add Loan</h5>
            </div>

            <form id="loanForm">
                @csrf

                <input type="hidden" id="loan_id">

                <div class="modal-body">
                    <label>Employee</label>
                    <select class="form-control" name="employee_id" id="employee_id" required>
                        <option value="">-- Select Employee --</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->empID }}">{{ $emp->fname }}</option>
                        @endforeach
                    </select>

                    <label class="mt-2">Loan Type</label>
                    <select class="form-control" name="loan_type" id="loan_type" required>
                        <option value="">-- Select Loan Type --</option>
                        <option value="pagibig">Pag-IBIG</option>
                        <option value="sss">SSS</option>
                        <option value="philhealth">PhilHealth</option>
                        <option value="salary">Salary Loan</option>
                    </select>

                    <label class="mt-2">Loan Amount</label>
                    <input type="number" step="0.01" class="form-control" name="loan_amount" id="loan_amount" required>

                    <label class="mt-2">Monthly Amortization</label>
                    <input type="number" step="0.01" class="form-control" name="monthly_amortization" id="monthly_amortization" required>

                    <label class="mt-2">Start Date</label>
                    <input type="date" class="form-control" name="start_date" id="start_date" required>

                    <label class="mt-2">End Date</label>
                    <input type="date" class="form-control" name="end_date" id="end_date">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
$('#addLoanBtn').click(function () {
    $('#loanForm')[0].reset();
    $('#loan_id').val('');
    $('#modalTitle').text('Add Loan');
    $('#loanModal').modal('show');
});

$('.editLoanBtn').click(function () {
    $('#modalTitle').text('Edit Loan');
    $('#loan_id').val($(this).data('id'));
    $('#employee_id').val($(this).data('employee'));
    $('#loan_type').val($(this).data('type'));
    $('#loan_amount').val($(this).data('amount'));
    $('#monthly_amortization').val($(this).data('amort'));
    $('#start_date').val($(this).data('start'));
    $('#end_date').val($(this).data('end'));
    $('#loanModal').modal('show');
});


$('#loanForm').submit(function (e) {
    e.preventDefault();
    let url = $('#loan_id').val() ? "{{ route('loans.update') }}" : "{{ route('loans.store') }}";

    axios.post(url, new FormData(this)).then(res => {
        Swal.fire('Success', 'Loan saved successfully!', 'success').then(() => location.reload());
    });
});

$('.deleteLoanBtn').click(function () {
    let id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: 'This will permanently delete the loan',
        icon: 'warning',
        showCancelButton: true,
    }).then(result => {
        if (result.isConfirmed) {
            axios.delete("/loans/delete/" + id).then(() => {
                Swal.fire('Deleted!', 'Loan removed', 'success').then(() => location.reload());
            });
        }
    });
});
</script>

@endsection

 

 
