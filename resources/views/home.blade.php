@extends('layout.app')
@section('content')

<style>
.table thead th {
    position: sticky !important;
    top: 0;
    background-color: #f8f9fa;
    z-index: 10;
}
</style>

<div class="container-fluid">
    <div class="pb-2 d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-0">SHIFT MONITORING</h4>
    </div>

    <div class="row">
        <div class="col-auto">
            <div class="form-group">
                <div class="col-12 p-0">
                    <input type="date" id="txtDateFrom" value="{{ date('Y-m-d', strtotime('-10 days')) }}" class="p-2 rounded border border-1">
                    <input type="date" id="txtDateTo" value="{{ date('Y-m-d') }}" class="p-2 rounded border border-1">
                    <button type="button" id="btnLogRef" class="btn text-white" style="background-color: #008080">
                        <i class="fa fa-refresh"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <h5 class="px-4 pt-4 mb-0">ATTENDANCE LOG</h5>
        <div class="card-body">
            <div class="row">
                <div class="table-responsive overflow-auto">
                    <table class="table table-hover" id="attendanceTable">
    <thead class="text-center">
        <th>Date</th>
        <th>Day</th>
        <th>Time In</th>
        <th>Time Out</th>
        <th>Duration</th>
        <th>Night Diff</th>
        <th>Remarks</th>
    </thead>
    <tbody id="tblAttendance" class="text-center"></tbody>
</table>
                </div>
            </div>
        </div>
    </div>

    {{-- BUTTON SECTION --}}
    <div class="row">
        <div class="px-2">
            <button type="button" id="btnTimeIn" class="btn text-white float-end ms-2" style="background-color:#008080">🕒 Time In</button>
            <button type="button" id="btnTimeOut" class="btn text-white float-end" style="background-color:#c0392b">🚪 Time Out</button>
        </div>
    </div>
</div>

 

<script>
$(document).ready(function () {

    // ============================
    // 🕒 TIME IN
    // ============================
    $('#btnTimeIn').click(function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Confirm Time In?',
            text: 'Do you want to log your time in now?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, log me in',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#008080'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Logging your time-in...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                axios.post("{{ route('attendance.timein') }}")
                    .then(res => {
                        Swal.close();
                        Swal.fire({
                            icon: res.data.status === 'success' ? 'success' : 'warning',
                            title: res.data.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        loadAttendance();
                    })
                    .catch(err => {
                        Swal.close();
                        Swal.fire('Error', 'Something went wrong', 'error');
                    });
            }
        });
    });

    // ============================
    // 🚪 TIME OUT
    // ============================
    $('#btnTimeOut').click(function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Confirm Time Out?',
            text: 'Do you want to log your time out now?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, log me out',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#c0392b'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Logging your time-out...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                axios.post("{{ route('attendance.timeout') }}")
                    .then(res => {
                        Swal.close();
                        Swal.fire({
                            icon: res.data.status === 'success' ? 'success' : 'warning',
                            title: res.data.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        loadAttendance();
                    })
                    .catch(err => {
                        Swal.close();
                        Swal.fire('Error', 'Something went wrong', 'error');
                    });
            }
        });
    });

    // ============================
    // 🔄 LOAD ATTENDANCE LIST
    // ============================
    // function loadAttendance() {
    //     axios.get('/api/attendance/list') // optional route if you have one
    //         .then(res => {
    //             let data = res.data;
    //             let html = '';
    //             data.forEach(row => {
    //                 html += `
    //                     <tr>
    //                         <td>${row.attendance_date}</td>
    //                         <td>${row.day}</td>
    //                         <td>${row.schedule ?? '-'}</td>
    //                         <td>${row.time_in ?? '-'}</td>
    //                         <td>${row.time_out ?? '-'}</td>
    //                         <td>${row.status ?? '-'}</td>
    //                         <td>${row.duration_hours ?? '-'}</td>
    //                     </tr>
    //                 `;
    //             });
    //             $('#tblAttendance').html(html);
    //         })
    //         .catch(() => {
    //             $('#tblAttendance').html('<tr><td colspan="7" class="text-center text-muted">Failed to load attendance logs.</td></tr>');
    //         });
    // }

    loadAttendance();

 function loadAttendance(from, to) {
    axios.get('/attendance/list', { params: { from, to } })
    .then(res => {
        const tbody = document.getElementById('tblAttendance');
        tbody.innerHTML = '';

        const punches = res.data.punches;
        const summary = res.data.summary;

        const grouped = {};
        punches.forEach(p => {
            if (!grouped[p.attendance_date]) grouped[p.attendance_date] = [];
            grouped[p.attendance_date].push(p);
        });

        Object.keys(grouped).forEach(date => {
            grouped[date].forEach(p => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${p.attendance_date}</td>
                    <td>${p.day}</td>
                    <td>${p.time_in}</td>
                    <td>${p.time_out}</td>
                    <td>${p.duration}</td>
                    <td>${p.night_diff}</td>
                    <td>${p.remarks}</td>
                `;
                tbody.appendChild(tr);
            });

            const s = summary.find(x => x.attendance_date === date);
            if (s) {
                const tr = document.createElement('tr');
                tr.classList.add('fw-bold','table-secondary');

                let lateStyle = s.mins_late > 0 ? 'color:red;' : '';
                let undertimeStyle = s.mins_undertime > 0 ? 'color:orange;' : '';

                tr.innerHTML = `
                    <td colspan="3">Summary</td>
                    <td>Total Hours: ${s.total_hours} hrs</td>
                    <td>Night Diff: ${s.mins_night_diff} mins</td>
                    <td style="${lateStyle}">Late: ${s.mins_late} mins</td>
                    <td style="${undertimeStyle}">Undertime: ${s.mins_undertime} mins</td>
                    <td>Status: ${s.status}</td>
                `;
                tbody.appendChild(tr);
            }
        });
    })
    .catch(err => console.error(err));
}

// Initial load
loadAttendance(document.getElementById('txtDateFrom').value, document.getElementById('txtDateTo').value);

// Refresh button
document.getElementById('btnLogRef').addEventListener('click', () => {
    loadAttendance(document.getElementById('txtDateFrom').value, document.getElementById('txtDateTo').value);
});

// Initial load
loadAttendance(document.getElementById('txtDateFrom').value, document.getElementById('txtDateTo').value);

// Refresh button
document.getElementById('btnLogRef').addEventListener('click', () => {
    loadAttendance(document.getElementById('txtDateFrom').value, document.getElementById('txtDateTo').value);
});


    $('#btnLogRef').click(function() {
        loadAttendance();
    });
});
</script>
@endsection
