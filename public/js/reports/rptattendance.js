document.addEventListener('DOMContentLoaded', function () {

  const fetchAttendance = async () => {
    const empID = document.getElementById('txtLastname')?.value || '';
    const dateFrom = document.getElementById('txtDateFrom')?.value || '';
    const dateTo = document.getElementById('txtDateTo')?.value || '';
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    const token = tokenMeta ? tokenMeta.getAttribute('content') : '';

    const tableBody = document.getElementById('tbl_rptattendance');
    tableBody.innerHTML = `<tr><td colspan="11">Loading...</td></tr>`;

    try {
        const response = await axios.post('/attendance/fetch', {
            employee_id: empID,
            date_from: dateFrom,
            date_to: dateTo,
        }, {
            headers: { 'X-CSRF-TOKEN': token },
        });

        const data = response.data;
        let grouped = {};

        // Group by employee name
        data.forEach(item => {
            const emp = item.employee;
            const empName = emp ? `${emp.lname}, ${emp.fname}` : 'Unknown';
            if (!grouped[empName]) grouped[empName] = [];
            grouped[empName].push(item);
        });

        let rows = '';
        let rowCount = 1;

        if (Object.keys(grouped).length > 0) {
            for (const [empName, records] of Object.entries(grouped)) {
                let empTotalHours = 0;
                let empTotalLate = 0;
                let empTotalUnder = 0;
                let empTotalNight = 0;
                let empTotalPassout = 0;
                let empTotalOverBreak = 0;

                // Loop per date record
                records.forEach(item => {
                    // ✅ Build list of all time-ins/outs for that day
                    let timeLogsIn = '-';
                    let timeLogsOut = '-';

                    if (item.home_attendances && item.home_attendances.length > 0) {
                        const formatted = item.home_attendances.map(h => {
                            const tin = h.time_in
                                ? new Date(h.time_in).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true })
                                : '-';
                            const tout = h.time_out
                                ? new Date(h.time_out).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true })
                                : '-';
                            return { tin, tout };
                        });

                        timeLogsIn = formatted.map(f => f.tin).join('<br>');
                        timeLogsOut = formatted.map(f => f.tout).join('<br>');
                    }

                    const duration = parseFloat(item.total_hours ?? 0);
                    const late = parseInt(item.mins_late ?? 0);
                    const under = parseInt(item.mins_undertime ?? 0);
                    const night = parseInt(item.mins_night_diff ?? 0);
                    const passout = parseInt(item.outpass_minutes ?? 0);
                    const overBreak = parseInt(item.over_break_minutes ?? 0);

                    empTotalHours += duration;
                    empTotalLate += late;
                    empTotalUnder += under;
                    empTotalNight += night;
                    empTotalPassout += passout;
                    empTotalOverBreak += overBreak;

                    rows += `
                        <tr class="text-center">
                            <td>${rowCount++}</td>
                            <td class="text-capitalize text-start">${empName}</td>
                             <td>${item.attendance_date ? new Date(item.attendance_date).toISOString().split('T')[0] : '-'}</td>

                            <td>${timeLogsIn}</td>
                            <td>${timeLogsOut}</td>
                            <td>${duration.toFixed(2)} hrs</td>
                            <td>${late}</td>
                            <td>${under}</td>
                            <td>${night}</td>
                            <td>${passout}</td>
                            <td>${overBreak}</td>
                        </tr>
                    `;
                });

                // Employee subtotal
                rows += `
                    <tr class="fw-bold bg-light text-center">
                        <td colspan="5" class="text-end">Total:</td>
                        <td>${empTotalHours.toFixed(2)} hrs</td>
                        <td>${empTotalLate}</td>
                        <td>${empTotalUnder}</td>
                        <td>${empTotalNight}</td>
                        <td>${empTotalPassout}</td>
                        <td>${empTotalOverBreak}</td>
                    </tr>
                `;
            }
        } else {
            rows = '<tr><td colspan="11">No attendance records found</td></tr>';
        }

        tableBody.innerHTML = rows;
        document.querySelector('.rptDateRange').textContent = `${dateFrom} to ${dateTo}`;
    } catch (error) {
        console.error(error);
        tableBody.innerHTML = `<tr><td colspan="11" class="text-danger">Error loading data</td></tr>`;
    }
};



    // Initial load
    fetchAttendance();

    // Refresh button
    document.getElementById('btn_rptrefresh').addEventListener('click', fetchAttendance);

    // Print button
    document.getElementById('btn_rptprint').addEventListener('click', () => {
        const printArea = document.getElementById('Report_thisPrint').innerHTML;
        const printWindow = window.open('', '_blank', 'width=900,height=600');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Attendance Report</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        table { width: 100%; border-collapse: collapse; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
                        th { background-color: #f2f2f2; }
                        .fw-bold { font-weight: bold; }
                        .bg-secondary { background-color: #495057; color: #fff; }
                        .bg-warning { background-color: #ffeeba; }
                        .bg-light { background-color: #f8f9fa; }
                        h2 { text-align: center; margin-bottom: 10px; }
                    </style>
                </head>
                <body>
                    <h2>Attendance Report</h2>
                    <p><strong>Date Range:</strong> ${document.getElementById('txtDateFrom').value} - ${document.getElementById('txtDateTo').value}</p>
                    ${printArea}
                </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    });
});
