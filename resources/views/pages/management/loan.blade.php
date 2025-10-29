@extends('layout.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between">
        <h3>Charges/Penalty/Loan Management</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loanModal" id="addLoanBtn">
            Add 
        </button>
    </div>

    <div class="table-responsive mt-3 shadow-sm">
    <table class="table table-bordered">
        <thead style="background-color: #f1f1f1;">
            <tr>
                <th>Employee</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Balance</th>
                <th>Amortization</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Action</th>
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
                    <button class="btn btn-sm btn-outline-danger deleteLoanBtn" data-id="{{ $loan->id }}">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</div>


<!-- Modal -->
<div class="modal fade" id="loanModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalTitle">Add Charges/Penalty/Loan</h5>
            </div>

            <form id="loanForm">
                @csrf

                <input type="hidden" id="loan_id" name="loan_id">

                <div class="modal-body">
                    <label>Employee</label>
                    <select class="form-control text-uppercase" name="employee_id" id="employee_id" required>
                        <option value="">-- Select Employee --</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->empID }}">{{ $emp->fname }}</option>
                        @endforeach
                    </select>

                    <label class="mt-2">Charges Type</label>
                    <select class="form-control text-uppercase" name="loan_type" id="loan_type" required>
                        <option value="">-- Select Type --</option>
                        <option value="pagibig">Pag-IBIG Loan</option>
                        <option value="sss">SSS Loan</option>
                        {{-- <option value="philhealth">PhilHealth</option> --}}
                        <option value="salary">Salary Loan</option>
                        <option value="cash_adv">Cash Advance</option>
                        <option value="charges/penalty">Charges/Penalty</option>
                        <option value="other">Other</option>
                    </select>

                    <label class="mt-2"> Amount</label>
                    <input type="number" step="0.01" class="form-control" name="loan_amount" id="loan_amount" required>

                    <label class="mt-2"> Amortization</label>
                    <input type="number" step="0.01" class="form-control text-uppercase" name="monthly_amortization" id="monthly_amortization" required>

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
    $('#modalTitle').text('Add Loan/Charges');
    $('#loanModal').modal('show');
});

$('.editLoanBtn').click(function () {
    $('#modalTitle').text('Edit Data');
    $('#loan_id').val($(this).data('id'));
    $('#employee_id').val($(this).data('employee'));
    $('#loan_type').val($(this).data('type'));
    $('#loan_amount').val($(this).data('amount'));
    $('#monthly_amortization').val($(this).data('amort'));
    $('#start_date').val($(this).data('start'));
    $('#end_date').val($(this).data('end'));
    $('#loanModal').modal('show');
});

const storeUrl = "{{ route('loans.store') }}";
const updateUrl = "{{ route('loans.update') }}";

axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

$('#loanForm').submit(function (e) {
    e.preventDefault();
    let url = $('#loan_id').val() ? updateUrl : storeUrl;

    axios.post(url, new FormData(this), {
        headers: { 'Content-Type': 'multipart/form-data' }
    })
    .then(res => {
        Swal.fire('Success', 'Item saved successfully!', 'success')
            .then(() => location.reload());
    })
    .catch(err => {
        console.log(err);
        Swal.fire('Error', 'Something went wrong!', 'error');
    });
});

$('.deleteLoanBtn').click(function () {
    let id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: 'This will permanently delete the item',
        icon: 'warning',
        showCancelButton: true,
    }).then(result => {
        if (result.isConfirmed) {
            axios.delete("/loans/delete/" + id).then(() => {
                Swal.fire('Deleted!', 'Item removed', 'success').then(() => location.reload());
            });
        }
    });
});
</script>

@endsection

 

 
