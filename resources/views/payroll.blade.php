<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Payroll</title>
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
                    <a href="/payroll">
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


                <div class="name">
                    <h4>{{ auth()->user()->name }}</h4>
                </div>

                <div class="user">
                    <img src="{{ url('img/usericon.svg') }}" alt="">
                </div>
            </div>

            <div class="main-content">
                <h2>{{ now()->format('F j, Y') }}</h2>


                <!-- Filters -->
                <div class="filter-group">
                    <div class="search-container">
                        <input type="text" id="searchInput" placeholder="Search name" onkeyup="filterTable()" />
                        <i class="fas fa-search"></i>
                    </div>

                    <input type="date" id="searchDate" onchange="filterTable()">

                    <select id="positionFilter" onchange="filterTable()">
                        <option value="">All Positions</option>
                        <option value="Barista">Barista</option>
                        <option value="kitchen Staff">Kitchen Staff</option>

                    </select>

                    <div class="filter-group">
                        <select id="typeFilter" onchange="filterTable()">
                            <option value="">All Types</option>
                            <option value="Regular">Regular</option>
                            <option value="Part-Timer">Part-Timer</option>

                        </select>
                    </div>
                </div>

            </div>

            <!-- Employee Table -->
            <div class="employee-table">
                <h2>Payroll</h2>

                <table id="myTable">
                    <thead>
                        <tr>
                            <th> Date </th>
                            <th>Name</th>
                            <th>Position</th>
                            <th> Type</th>
                            <th>Basic Salary</th>
                            <th>Total Overtime Pay</th>
                            <th>Total Deductions</th>
                            <th>Net Salary</th>
                            <th>View Detail</th>
                        </tr>

                    </thead>

                    <tbody>
                        @foreach($payrollData as $data)
                        <tr>
                            <td>{{ now()->format('m-d-Y') }}</td>
                            <td>{{ $data['name'] }}</td>
                            <td>{{ $data['position'] }}</td>
                            <td>{{ $data['type'] }}</td>
                            <td>₱ {{ $data['basic_salary'] }}</td>
                            <td>₱ {{ $data['overtime_pay'] }}</td>
                            <td>₱ {{ $data['deductions'] }}</td>
                            <td>₱ {{ $data['net_salary'] }}</td>
                            <td class="view-btn" onclick="openDtrModal('{{ $data['name'] }}', '{{ now()->format('F') }}')">
                                <i class="fas fa-eye"></i>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div id="dtrModal" class="modal">
            <div class="modal-content">
                <!-- Close button positioned at top right corner -->

                <span class="close-btn" onclick="closeModal()">&times;</span>

                <div class="main-content">
                    <h3>Employee DTR for <span id="modalEmployeeName">Sheina Labadan</span> - Month of <span
                            id="modalMonth">March</span></h3>

                    <div class="filter-group">

                        <select id="monthFilter" onchange="filterTable()">
                            <option value="">Month</option>
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
                            <option value="">Year</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                        </select>




                    </div>
                </div>

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
                        <!-- Dynamic content will be inserted here -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7"><strong>Net Salary</strong></td>
                            <td colspan="2" style="text-align: right;" id="netSalary">0.00</td>
                        </tr>
                    </tfoot>
                </table>
                <!-- Pagination Controls -->
                <div id="paginationControls">
                    <button id="prevPageBtn" onclick="changePage(-1)" disabled>Previous</button>
                    <span id="pageIndicator">Page 1</span>
                    <button id="nextPageBtn" onclick="changePage(1)">Next</button>
                </div>
            </div>
        </div>

        <script src="{{ url('JS/sidebar.js') }}"></script>


        <!-- SA EYE MODAL -->
        <script>
            
        </script>

</body>
<script src="{{ url('JS/payroll.js') }}"></script>
</html>
