@extends('layout.app')

@section('content')

<div class="container-fluid mt-4">
    <div class="pb-2">
        <h4>Settings / <label class="text-black">Scheduling Module</label></h4>
    </div>

    <div class="row pb-3 align-items-end">
        <div class="col-lg-4 col-md-6">
            <button class="btn btn-primary mb-2" id="btnCreateModal" data-bs-toggle="modal" data-bs-target="#mdlEmpScheduler">
                Add Schedule
            </button>
        </div>

        <div class="col-lg-4 col-md-3">
            <input type="text" id="txtSearchEmp" class="form-control" placeholder="Search Employee...">
        </div>

        <div class="col-lg-4 col-md-3">
            <select id="selPerPage" class="form-select">
                <option value="10">10 entries</option>
                <option value="25">25 entries</option>
                <option value="50">50 entries</option>
                <option value="100">100 entries</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Shift</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tblEmpScheduler">
                    <!-- AJAX populated -->
                </tbody>
            </table>

            <!-- Pagination -->
            <div id="paginationContainer" class="mt-3 d-flex justify-content-end"></div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="mdlEmpScheduler" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Employee Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="frmEmpScheduler">
                    <input type="hidden" id="schedule_id">

                    <div class="mb-2">
                        <label>Employee</label>
                        <select class="form-select" id="selEmployee" name="employee_id">
                            <option selected disabled>Select Employee</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->empID }}">{{ $emp->lname }}, {{ $emp->fname }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text employee_id_error"></span>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label>Start Date</label>
                            <input type="date" class="form-control" name="sched_start_date" id="sched_start_date">
                            <span class="text-danger error-text sched_start_date_error"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label>End Date</label>
                            <input type="date" class="form-control" name="sched_end_date" id="sched_end_date">
                            <span class="text-danger error-text sched_end_date_error"></span>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label>Apply To Days</label>
                        <div class="d-flex flex-wrap gap-2">
                            @php
                                $days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
                            @endphp
                            @foreach($days as $day)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input day-check" type="checkbox" value="{{ $day }}" id="chk{{ $day }}">
                                    <label class="form-check-label" for="chk{{ $day }}">{{ $day }}</label>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted">Select which days to repeat within range.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label>Schedule In</label>
                            <input type="time" class="form-control" name="sched_in" id="sched_in">
                            <span class="text-danger error-text sched_in_error"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Schedule Out</label>
                            <input type="time" class="form-control" name="sched_out" id="sched_out">
                            <span class="text-danger error-text sched_out_error"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label>Break Start</label>
                            <input type="time" class="form-control" name="break_start" id="break_start">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Break End</label>
                            <input type="time" class="form-control" name="break_end" id="break_end">
                        </div>
                    </div>

                    <div class="mb-2">
                        <label>Shift Type</label>
                        <input type="text" class="form-control" name="shift_type" id="shift_type">
                        <span class="text-danger error-text shift_type_error"></span>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" id="btnSaveScheduler" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function(){

    // 🧩 LOAD SCHEDULES
    const loadSchedules = (search = '', page = 1, perPage = 10) => {
        axios.get("{{ route('employee-schedules.get') }}", {
            params: { search, page, per_page: perPage }
        })
        .then(res => {
            const data = res.data.data;
            let html = '';

            data.forEach(s => {
                html += `
                    <tr>
                        <td>${s.employee_name}</td>
                        <td>${s.sched_start_date} ${s.sched_in}</td>
                        <td>${s.sched_end_date} ${s.sched_out}</td>
                        <td>${s.shift_type ?? ''}</td>
                        <td>
                            <button class="btn btn-sm btn-primary btnEdit" data-id="${s.id}">Edit</button>
                            <button class="btn btn-sm btn-danger btnDelete" data-id="${s.id}">Delete</button>
                        </td>
                    </tr>`;
            });

            $('#tblEmpScheduler').html(html);

            // Pagination builder
            let pagination = '';
            if (res.data.last_page > 1) {
                pagination += `<nav><ul class="pagination justify-content-end">`;
                for (let i = 1; i <= res.data.last_page; i++) {
                    pagination += `
                        <li class="page-item ${i === res.data.current_page ? 'active' : ''}">
                            <a href="#" class="page-link" data-page="${i}">${i}</a>
                        </li>`;
                }
                pagination += `</ul></nav>`;
            }
            $('#paginationContainer').html(pagination);
        })
        .catch(err => {
            console.error(err);
        });
    };

    // 🔹 Initial Load
    loadSchedules();

    // 🔍 Search
    $('#txtSearchEmp').on('keyup', function(){
        loadSchedules($(this).val(), 1, $('#selPerPage').val());
    });

    // 📄 Pagination
    $(document).on('click', '.page-link', function(e){
        e.preventDefault();
        const page = $(this).data('page');
        loadSchedules($('#txtSearchEmp').val(), page, $('#selPerPage').val());
    });

    // 🔢 Per Page
    $('#selPerPage').on('change', function(){
        loadSchedules($('#txtSearchEmp').val(), 1, $(this).val());
    });

        $('#btnSaveScheduler').on('click', function() {
        let schedule_id = $('#schedule_id').val();
        let url = schedule_id
            ? `{{ url('employee-schedules/update') }}/${schedule_id}`
            : "{{ route('employee-schedules.store') }}";
        let method = schedule_id ? 'put' : 'post';

        let selectedDays = [];
        $('.day-check:checked').each(function() {
            selectedDays.push($(this).val());
        });

        let formData = {
            employee_id: $('#selEmployee').val(),
            sched_start_date: $('#sched_start_date').val(),
            sched_in: $('#sched_in').val(),
            sched_end_date: $('#sched_end_date').val(),
            sched_out: $('#sched_out').val(),
            shift_type: $('#shift_type').val(),
            break_start: $('#break_start').val(),
            break_end: $('#break_end').val(),
            days: selectedDays,
        };

        Swal.fire({
            title: 'Saving...',
            text: 'Please wait while we process the schedule.',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        axios({ method, url, data: formData })
            .then(res => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: res.data.message,
                    timer: 1800,
                    showConfirmButton: false
                });

                $('#mdlEmpScheduler').modal('hide');
                $('#frmEmpScheduler')[0].reset();
                $('#schedule_id').val('');
                loadSchedules();
            })
            .catch(err => {
                Swal.close();

                if (err.response) {
                    let { status, data } = err.response;

                    // 🔸 Validation error (422)
                    if (status === 422) {
                        let errors = data.errors;
                        $('.error-text').text('');
                        Object.keys(errors).forEach(key => {
                            $(`.${key}_error`).text(errors[key][0]);
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: 'Please review the highlighted fields.',
                            customClass: 'swal-mini-popup'
                        });
                    }

                    // 🔸 Schedule conflict (409)
                    else if (status === 409) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Schedule Conflict',
                            text: data.error,
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'OK',
                            customClass: 'swal-mini-popup'
                        });
                    }

                    // 🔸 Other server errors
                    else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'An unexpected error occurred.',
                            customClass: 'swal-mini-popup'
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Network Error',
                        text: 'Please check your internet connection and try again.',
                        customClass: 'swal-mini-popup'
                    });
                }
            });
    });


    $(document).on('click', '.btnEdit', function(){
        let id = $(this).data('id');
        axios.get(`{{ url('employee-schedules/edit') }}/${id}`)
        .then(res => {
            let s = res.data;
            $('#schedule_id').val(s.id);
            $('#selEmployee').val(s.employee_id);
            $('#sched_start_date').val(s.sched_start_date);
            $('#sched_in').val(s.sched_in);
            $('#sched_end_date').val(s.sched_end_date);
            $('#sched_out').val(s.sched_out);
            $('#shift_type').val(s.shift_type);
            $('#break_start').val(s.break_start);
            $('#break_end').val(s.break_end);
            $('#mdlEmpScheduler').modal('show');

        });
    });

    $(document).on('click', '.btnDelete', function(){
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if(result.isConfirmed){
                axios.delete(`{{ url('employee-schedules/delete') }}/${id}`)
                .then(res => {
                    Swal.fire('Deleted!', res.data.message, 'success');
                    loadSchedules();
                });
            }
        });
    });

});
</script>
@endsection
