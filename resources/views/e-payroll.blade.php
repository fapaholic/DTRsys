<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E - Payroll</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <link rel="stylesheet" href="{{ url('CSS/payroll.css') }}" />
    <link rel="stylesheet" href="{{ url('CSS/sidebar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</head>

<body>

    <!-- =============== Navigation ================ -->
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
                <a href="/e-dashboard">
                    <span class="icon">
                        <ion-icon name="home"></ion-icon>
                    </span>
                    <span class="title">Dashboard</span>
                </a>
            </li>


            <li>
                <a href="/e-attendance">
                    <span class="icon">
                        <ion-icon name="calendar"></ion-icon>
                    </span>
                    <span class="title">Attendance Logs</span>
                </a>
            </li>

            <li>
                <a href="/e-payroll">
                    <span class="icon">
                        <ion-icon name="cash"></ion-icon>
                    </span>
                    <span class="title">Payroll</span>
                </a>
            </li>



            <li class="logout">
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



            <div class="user">
                <img src="{{ url('img/usericon.svg') }}" alt="">
            </div>
        </div>

        <div class="main-content">
            <h2>April 1, 2025</h2>

            <div class="filter-group">

                <select id="monthFilter" onchange="filterTable()">
                    <option value="">All Month</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>

                </select>

                <select id="yearFilter" onchange="filterTable()">
                    <option value="">All Year</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                </select>


                <select id="statusFilter" onchange="filterTable()">
                    <option value="">All Status</option>
                    <option value="On Time">On Time</option>
                    <option value="Late">Late</option>
                    <option value="Absent">Absent</option>
                </select>

            </div>
        </div>


        <!-- Employee Table -->
        <div class="employee-table">
            <h2>Payroll</h2>
            <table id="dtrTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time In (AM)</th>
                        <th>Time Out (AM)</th>
                        <th>Time In (PM)</th>
                        <th>Time Out (PM)</th>
                        <th>Working Hours</th>
                        <th>Status</th>
                        <th>Deductions</th>
                        <th>Salary</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>01-01-2026</td>
                        <td>8:00 am</td>
                        <td></td>
                        <td></td>
                        <td>2:00 pm</td>
                        <td>8</td>
                        <td>Late</td>
                        <td>0</td>
                        <td>300</td>

                    </tr>

                    <tr>
                        <td>02-02-2025</td>
                        <td>8:00 am</td>
                        <td></td>
                        <td></td>
                        <td>2:00 pm</td>
                        <td>8</td>
                        <td>On Time</td>
                        <td>0</td>
                        <td>300</td>

                    </tr>

                    <tr>
                        <td>03-03-2025</td>
                        <td>8:00 am</td>
                        <td></td>
                        <td></td>
                        <td>2:00 pm</td>
                        <td>8</td>
                        <td>Absent</td>
                        <td>0</td>
                        <td>300</td>

                    </tr>

                    <tr>
                        <td>04-04-2025</td>
                        <td>8:00 am</td>
                        <td></td>
                        <td></td>
                        <td>2:00 pm</td>
                        <td>8</td>
                        <td>Absent</td>
                        <td>0</td>
                        <td>300</td>

                    </tr>

                    <tr>
                        <td>05-05-2025</td>
                        <td>8:00 am</td>
                        <td></td>
                        <td></td>
                        <td>2:00 pm</td>
                        <td>8</td>
                        <td>On Time</td>
                        <td>0</td>
                        <td>300</td>

                    </tr>

                    <tr>
                        <td>06-06-2025</td>
                        <td>8:00 am</td>
                        <td></td>
                        <td></td>
                        <td>2:00 pm</td>
                        <td>8</td>
                        <td>On Time</td>
                        <td>0</td>
                        <td>300</td>

                    </tr>

                    <tr>
                        <td>07-07-2025</td>
                        <td>8:00 am</td>
                        <td></td>
                        <td></td>
                        <td>2:00 pm</td>
                        <td>8</td>
                        <td>On Time</td>
                        <td>0</td>
                        <td>300</td>

                    </tr>

                    <tr>
                        <td>08-08-2025</td>
                        <td>8:00 am</td>
                        <td></td>
                        <td></td>
                        <td>2:00 pm</td>
                        <td>8</td>
                        <td>On Time</td>
                        <td>0</td>
                        <td>300</td>

                    </tr>

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7"><strong>Net Salary</strong></td>
                        <td colspan="2" style="text-align: right;" id="netSalary">0.00</td>
                    </tr>
                </tfoot>



            </table>
            <!-- Pagination Controls -->
            <div class="pagination">
                <button id="prevPage" onclick="changePage(-1)">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
                <span id="pageNumber">Page 1</span>
                <button id="nextPage" onclick="changePage(1)">
                    Next <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>

    <script src="{{ url('JS/sidebar.js') }}"></script>


    <script>
        // Function to filter the table rows based on selected filters
        function filterTable() {
            var monthFilter = document.getElementById("monthFilter").value;
            var yearFilter = document.getElementById("yearFilter").value;
            var statusFilter = document.getElementById("statusFilter").value;

            var table = document.getElementById("dtrTable");
            var rows = table.getElementsByTagName("tr");

            // Loop through all table rows (excluding the header)
            for (var i = 1; i < rows.length; i++) {
                var row = rows[i];
                var dateCell = row.cells[0].innerText;
                var statusCell = row.cells[6].innerText;

                // Extract month and year from the date (assumed format: MM-DD-YYYY)
                var dateParts = dateCell.split("-");
                var rowMonth = dateParts[0];
                var rowYear = dateParts[2];

                // Check if the row matches the selected filters
                var monthMatch = (monthFilter === "" || monthFilter === rowMonth);
                var yearMatch = (yearFilter === "" || yearFilter === rowYear);
                var statusMatch = (statusFilter === "" || statusFilter === statusCell);

                // Show or hide the row based on the filters
                if (monthMatch && yearMatch && statusMatch) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }

            // Update net salary (sum of all displayed rows)
            updateNetSalary();
        }

        // Function to update the net salary based on the filtered rows
        function updateNetSalary() {
            var table = document.getElementById("dtrTable");
            var rows = table.getElementsByTagName("tr");
            var netSalary = 0;

            // Loop through all table rows (excluding the header)
            for (var i = 1; i < rows.length; i++) {
                var row = rows[i];
                if (row.style.display !== "none") { // Only consider visible rows
                    var salaryCell = row.cells[8].innerText;
                    netSalary += parseFloat(salaryCell);
                }
            }

            // Update the net salary cell
            document.getElementById("netSalary").innerText = netSalary.toFixed(2);
        }
    </script>



</body>

</html>
