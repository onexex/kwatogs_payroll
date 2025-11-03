document.addEventListener('DOMContentLoaded', function () {

    const fetchAttendance = async () => {
        const empID = document.getElementById('txtLastname')?.value || '';
        const dateFrom = document.getElementById('txtDateFrom')?.value || '';
        const dateTo = document.getElementById('txtDateTo')?.value || '';
        const tokenMeta = document.querySelector('meta[name="csrf-token"]');
        const token = tokenMeta ? tokenMeta.getAttribute('content') : '';

        const tableBody = document.getElementById('tbl_rptattendance');
        tableBody.innerHTML = `<tr><td colspan="9">Loading...</td></tr>`;

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

            // Group by employee_id
            data.forEach(item => {
                const emp = item.employee;
                const empName = emp ? `${emp.lname}, ${emp.fname}` : 'Unknown';
                if (!grouped[empName]) grouped[empName] = [];
                grouped[empName].push(item);
            });

            let rows = '';
            let grandTotalHours = 0;
            let grandLate = 0;
            let grandUnder = 0;
            let grandNight = 0;
            let rowCount = 1;

            if (Object.keys(grouped).length > 0) {
                for (const [empName, records] of Object.entries(grouped)) {
                    let empTotalHours = 0;
                    let empTotalLate = 0;
                    let empTotalUnder = 0;
                    let empTotalNight = 0;

                    // Employee Header Row
                    // rows += `
                    //     <tr class="fw-bold bg-secondary text-white">
                    //         <td colspan="9" class="text-start ps-2">${empName}</td>
                    //     </tr>
                    // `;
          
                    // Employee’s Daily Records
                    records.forEach((item, index) => {
                        //           const attendance = item.home_attendances?.[0] ?? {};
                        // function formatTime(timeString) {
                        //     if (!timeString) return '-';
                        //     const date = new Date(timeString);
                        //     return date.toLocaleTimeString('en-US', {
                        //         hour: '2-digit',
                        //         minute: '2-digit',
                        //         hour12: true,
                        //     });
                        // }
                        const timeIn = item.home_attendances?.[0]?.time_in ?? '-';
                        const timeOut = item.home_attendances?.[0]?.time_out ?? '-';
                        // const timeIn  = formatTime(attendance.time_in);
                        // const timeOut = formatTime(attendance.time_out);
                        const duration = item.total_hours ?? 0;
                        const late = item.mins_late ?? 0;
                        const under = item.mins_undertime ?? 0;
                        const night = item.mins_night_diff ?? 0;

                        empTotalHours += parseFloat(duration);
                        empTotalLate += parseInt(late);
                        empTotalUnder += parseInt(under);
                        empTotalNight += parseInt(night);

                        rows += `
                            <tr>
                                <td>${rowCount++}</td>
                                <td class="text-capitalize">${empName}</td>
                                <td>${item.attendance_date ?? '-'}</td>
                                <td>${timeIn}</td>
                                <td>${timeOut}</td>
                                <td>${duration} hrs</td>
                                <td>${late}</td>
                                <td>${under}</td>
                                <td>${night}</td>
                            </tr>
                        `;
                    });

                    // Employee Subtotal Row
                    rows += `
                        <tr class="fw-bold bg-light">
                     
                            <td colspan="5" class="text-end">Total:</td>
                            <td>${empTotalHours.toFixed(2)} hrs</td>
                            <td>${empTotalLate}</td>
                            <td>${empTotalUnder}</td>
                            <td>${empTotalNight}</td>
                        </tr>
                    `;

                    // Add to Grand Totals
                    grandTotalHours += empTotalHours;
                    grandLate += empTotalLate;
                    grandUnder += empTotalUnder;
                    grandNight += empTotalNight;
                }

                // // Grand Total Row
                // rows += `
                //     <tr class="fw-bold bg-warning">
                //         <td colspan="5" class="text-end">GRAND TOTAL:</td>
                //         <td>${grandTotalHours.toFixed(2)} hrs</td>
                //         <td>${grandLate}</td>
                //         <td>${grandUnder}</td>
                //         <td>${grandNight}</td>
                //     </tr>
                // `;

            } else {
                rows = '<tr><td colspan="9">No attendance records found</td></tr>';
            }

            tableBody.innerHTML = rows;
            document.querySelector('.rptDateRange').textContent = `${dateFrom} to ${dateTo}`;

        } catch (error) {
            console.error(error);
            tableBody.innerHTML = `<tr><td colspan="9" class="text-danger">Error loading data</td></tr>`;
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
