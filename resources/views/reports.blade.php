<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employee Management</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <link rel="stylesheet" href="{{ url('CSS/reports.css') }}" />
    <link rel="stylesheet" href="{{ url('CSS/sidebar.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</head>

<body>

    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="cafe"></ion-icon>
                        </span>
                        <span class="title">DTR System</span>
                    </a>
                </li>

                <li>
                    <a href="/">
                        <span class="icon">
                            <ion-icon name="home"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('/manage-employees') }}">
                        <span class="icon">
                            <ion-icon name="people"></ion-icon>
                        </span>
                        <span class="title">Employees</span>
                    </a>
                </li>

                <li>
                    <a href="/attendance-logs">
                        <span class="icon">
                            <ion-icon name="calendar"></ion-icon>
                        </span>
                        <span class="title">Attendance Logs</span>
                    </a>
                </li>

                <li>
                    <a href="payroll">
                        <span class="icon">
                            <ion-icon name="cash"></ion-icon>
                        </span>
                        <span class="title">Payroll</span>
                    </a>
                </li>

                <li>
                    <a href="/reports">
                        <span class="icon">
                            <ion-icon name="analytics"></ion-icon>
                        </span>
                        <span class="title">Reports</span>
                    </a>
                </li>


                <li>
                    <a href="{{ route('logout') }}">
                        <span class="icon">
                            <ion-icon name="log-out"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>


                <div class="name">
                    <h4>{{ auth()->user()->name }}</h4>
                </div>

                <div class="user">
                    <img src="{{ url('img/usericon.svg') }}" alt="">
                </div>
            </div>

            <div class="main-content">
                <h2>Reports</h2>



                <div class="filter-group">

                    <div class="search-container">
                        <input type="text" id="searchInput" placeholder="Search name" onkeyup="filterTable()" />
                        <i class="fas fa-search"></i>
                    </div>

                    <input type="date" id="dateFilter" onchange="filterTable()" />
                    <select id="positionFilter" onchange="filterTable()">
                        <option value="">All Positions</option>
                        <option value="Barista">Barista</option>
                        <option value="kitchen Staff">Kitchen Staff</option>

                    </select>


                    <select id="typeFilter" onchange="filterTable()">
                        <option value="">All Types</option>
                        <option value="Regular">Regular</option>
                        <option value="Part-Timer">Part-Timer</option>
                    </select>


                    <div class="filter-group">
                        <select id="statusFilter" onchange="filterTable()">
                            <option value="">All Status</option>
                            <option value="On Time">On Time</option>
                            <option value="Late">Late</option>
                            <option value="Absent">Absent</option>
                        </select>
                    </div>
                </div>
            </div>


            <div class="table"><!-- Employee Report Section -->
                <div class="report-section">
                    <h2>Attendance Report</h2>
                    <div class="filters">
                    </div>
                    <table>
                        <thead>
                            <tr>

                                <th>Date</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th> Type</th>
                                <th class = "hide">Time In</th>
                                <th class = "hide">Time Out</th>
                                <th>Working Hours</th>
                                <th>Status</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tbody id="reportTableBody">
                            <tr>
                                <td>2025-03-14</td>
                                <td>John Doe</td>
                                <td>Barista</td>
                                <td>Regular</td>

                                <td class = "hide">08:00 AM</td>
                                <td class = "hide">05:00 PM</td>
                                <td>8h</td>
                                <td>On Time</td>
                                <td>300</td>
                            </tr>
                            <tr>
                                <td>2025-03-14</td>
                                <td>Jane Smith</td>
                                <td>Barista</td>
                                <td>Part time</td>
                                <td class = 'hide'>08:15 AM</td>
                                <td class = 'hide'>05:05 PM</td>
                                <td>8h</td>
                                <td>Late</td>
                                <td>250</td>
                            </tr>
                            <tr>
                                <td>2025-03-14</td>
                                <td>Jane Smith</td>
                                <td>Barista</td>
                                <td>Part time</td>
                                <td class = "hide">08:15 AM</td>
                                <td class = "hide">05:05 PM</td>
                                <td>8h</td>
                                <td>Absent</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>2025-03-14</td>
                                <td>John Doe</td>
                                <td>Kitchen Staff</td>
                                <td>Regular</td>
                                <td class = "hide">08:00 AM</td>
                                <td class = "hide">05:00 PM</td>
                                <td>8h</td>
                                <td>On Time</td>
                                <td>300</td>
                            </tr>
                            <tr>
                                <td>2025-03-14</td>
                                <td>John Doe</td>
                                <td>Barista</td>
                                <td>Regular</td>
                                <td class = "hide">08:00 AM</td>
                                <td class = "hide">05:00 PM</td>
                                <td>8h</td>
                                <td>On Time</td>
                                <td>300</td>
                            </tr>
                        </tbody>
                    </table>
                </div>



                <div class="report-section">
                    <h2>Weekly Payroll Report</h2>
                    <div class="filters">
                    </div>
                    <table>
                        <thead>
                            <tr>


                                <th>Name</th>
                                <th>Position</th>
                                <th>Employee Type</th>
                                <th>Total Working Hours</th>
                                <th>Total Deduction</th>
                                <th>Net Salary</th>
                            </tr>
                        </thead>
                        <tbody id="reportTableBody">
                            <tr>

                                <td>John Doe</td>
                                <td>Barista</td>
                                <td>Regular</td>
                                <td>100 hrs</td>
                                <td>100</td>
                                <td>2,000</td>
                            </tr>

                            <tr>

                                <td>John Doe</td>
                                <td>Barista</td>
                                <td>Regular</td>
                                <td>100 hrs</td>
                                <td>100</td>
                                <td>2,000</td>
                            </tr>

                            <tr>

                                <td>John Doe</td>
                                <td>Kitchen Staff</td>
                                <td>Part time</td>
                                <td>100 hrs</td>
                                <td>100</td>
                                <td>2,000</td>
                            </tr>

                            <tr>
                            <tr>

                                <td>John Doe</td>
                                <td>Barista</td>
                                <td>Part time</td>
                                <td>100 hrs</td>
                                <td>100</td>
                                <td>2,000</td>
                            </tr>

                            <tr>

                                <td>John Doe</td>
                                <td>Barista</td>
                                <td>Regular</td>
                                <td>100 hrs</td>
                                <td>100</td>
                                <td>2,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>




            <div class="chart-section">
                <h2>Weekly Attendance Overview</h2>
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>


    </div>
    <!-- =========== Scripts =========  -->
     
    <script src="{{ url('JS/dashchart.js') }}"></script>


    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script src="{{ url('JS/sidebar.js') }}"></script>

    <script>
        function filterTable() {
            const searchInput = document.getElementById("searchInput").value.toLowerCase();
            const dateFilter = document.getElementById("dateFilter").value;
            const positionFilter = document.getElementById("positionFilter").value.toLowerCase();
            const statusFilter = document.getElementById("statusFilter").value.toLowerCase();
            const typeFilter = document.getElementById("typeFilter").value.toLowerCase();

            const table = document.querySelector(".report-section table"); // First table (Attendance Report)
            const tbody = table.querySelector("tbody");
            const rows = tbody.getElementsByTagName("tr");

            for (let row of rows) {
                const cells = row.getElementsByTagName("td");

                const date = cells[0].textContent.trim();
                const name = cells[1].textContent.trim().toLowerCase();
                const position = cells[2].textContent.trim().toLowerCase();
                const type = cells[3].textContent.trim().toLowerCase(); // 4th column is Type
                const status = cells[7].textContent.trim().toLowerCase(); // 8th column is Status

                let showRow = true;

                if (searchInput && !name.includes(searchInput)) showRow = false;
                if (dateFilter && date !== dateFilter) showRow = false;
                if (positionFilter && position !== positionFilter) showRow = false;
                if (typeFilter && type !== typeFilter) showRow = false;
                if (statusFilter && status !== statusFilter) showRow = false;

                row.style.display = showRow ? "" : "none";
            }
        }
    </script>



</body>

</html>
