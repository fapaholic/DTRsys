<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employee Management</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <link rel="stylesheet" href="{{ url('CSS/attendancelogs.css') }}" />
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
            <h2>{{ now()->format('F j, Y') }}</h2>



                <div class="filter-group">

                    <div class="search-container">
                        <input type="text" id="searchInput" placeholder="Search name" onkeyup="filterTable()" />
                        <i class="fas fa-search"></i>
                    </div>

                    <input type="date" id="dateFilter" onchange="filterTable()" />

                    <select id="positionFilter" onchange="filterTable()">

                        <option value="">All Positions</option>
                        <option value="Barista">Barista</option>
                        <option value="kitchen-staff">Kitchen Staff</option>

                    </select>

                    <div class="filter-group">
                        <select id="typeFilter" onchange="filterTable()">
                            <option value="">All Types</option>
                            <option value="regular">Regular</option>
                            <option value="part-timer">Part-Timer</option>

                        </select>

                    </div>

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


            <!-- Employee Table -->
            <div class="employee-table">
                <h2>Attendance Logs</h2>
                <table id="employeeTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Type</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Working Hours</th>
                            <th>Status</th>
                            <th>Salary</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($log->date)->format('m/d/Y') }}</td>
                                <td>{{ $log->name }}</td>
                                <td>{{ $log->position ?? 'N/A' }}</td>
                                <td>{{ ucfirst($log->type ?? 'N/A') }}</td>
                                <td>{{ $log->time_in ? \Carbon\Carbon::parse($log->time_in)->format('h:i A') : '' }}</td>
                                <td>{{ $log->time_out ? \Carbon\Carbon::parse($log->time_out)->format('h:i A') : '' }}</td>
                                <td>
                                    @if ($log->time_in && $log->time_out)
                                        @php
                                            $in = \Carbon\Carbon::parse($log->time_in);
                                            $out = \Carbon\Carbon::parse($log->time_out);
                                            $diffMinutes = $in->diffInMinutes($out);
                                            $hours = floor($diffMinutes / 60);
                                            $minutes = $diffMinutes % 60;
                                        @endphp
                                        {{ $hours > 0 ? $hours . 'h ' : '' }}{{ $minutes > 0 ? $minutes . 'm' : ($hours == 0 ? '0m' : '') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $log->status ?? 'N/A' }}</td>
                                <td>₱ {{ $log->salary ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">No attendance records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
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


        <!-- Add Filter Function -->
        <script>
            function filterTable() {
                const searchInput = document.getElementById("searchInput").value.toLowerCase();
                const dateFilter = document.getElementById("dateFilter").value;
                const positionFilter = document.getElementById("positionFilter").value.toLowerCase();
                const typeFilter = document.getElementById("typeFilter").value.toLowerCase();
                const statusFilter = document.getElementById("statusFilter").value.toLowerCase();

                const table = document.getElementById("employeeTable");
                const rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");

                let formattedDate = "";
                if (dateFilter) {
                    const dateObj = new Date(dateFilter);
                    const month = String(dateObj.getMonth() + 1).padStart(2, "0");
                    const day = String(dateObj.getDate()).padStart(2, "0");
                    const year = dateObj.getFullYear();
                    formattedDate = `${month}/${day}/${year}`;
                }

                for (let i = 0; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName("td");

                    const date = cells[0].textContent.toLowerCase();
                    const name = cells[1].textContent.toLowerCase();
                    const position = cells[2].textContent.toLowerCase();
                    const type = cells[3].textContent.toLowerCase();
                    const status = cells[9].textContent.toLowerCase();

                    const matchesSearch = name.includes(searchInput);
                    const matchesDate = !formattedDate || date.includes(formattedDate.toLowerCase());
                    const matchesPosition = !positionFilter || position.includes(positionFilter);
                    const matchesType = !typeFilter || type.includes(typeFilter);
                    const matchesStatus = !statusFilter || status.includes(statusFilter);

                    if (matchesSearch && matchesDate && matchesPosition && matchesType && matchesStatus) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";x
                    }
                }
            }
        </script>


</body>

</html>
