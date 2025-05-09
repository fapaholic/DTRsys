<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="{{ url('CSS/sidebar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

            <!-- ======================= Cards ================== -->
            <div class="stats">
                <div class="card" onclick="location.href='{{ route('/manage-employees') }}'">
                    <div class="card-content">
                        <div class="iconBx">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>

                    <div class="card-info">
                        <div class="txt">
                            <h3>Total Employees</h3>
                            <p>{{ $employeeCount }}</p>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="iconBx">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>

                    <div class="card-info">
                        <div class = "txt">
                        <h3>Present Today</h3>
                        <p>{{ $presentToday }}</p>

                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="iconBx">
                            <i class="fas fa-user-times"></i>
                        </div>
                    </div>

                    <div class="card-info">
                        <div class = "txt">
                            <h3>Absent Today</h3>
                            <p>{{ $absentToday }}</p>

                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-content">
                        <div class="iconBx">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>

                    <div class="card-info">
                        <div class = "txt">
                            <h3>Late Arrival</h3>
                            <p>{{ $lateToday }}</p>
                        </div>

                    </div>
                </div>
            </div>

            <div class="report-activity-section">
                <!-- Employee Report Section -->
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
                            @forelse($attendanceLogs as $log)
                                <tr>
                                    <td>{{ $log->date }}</td>
                                    <td>{{ $log->name }}</td>
                                    <td>{{ $log->position }}</td>
                                    <td>{{ ucfirst($log->type) }}</td>
                                    <td class="hide">{{ $log->time_in ? \Carbon\Carbon::parse($log->time_in)->format('h:i A') : '-' }}</td>
                                    <td class="hide">{{ $log->time_out ? \Carbon\Carbon::parse($log->time_out)->format('h:i A') : '-' }}</td>
                                    <td>
                                        @if ($log->time_in && $log->time_out)
                                            {{ \Carbon\Carbon::parse($log->time_out)->diffInHours(\Carbon\Carbon::parse($log->time_in)) }}h
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $log->status ?? 'Absent' }}</td>
                                    <td>{{ $log->salary ?? 0 }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="9">No attendance data for today.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Recent Activity Section -->
                <div class="recent-activity">
                    <h2>Recent Activity</h2>
                    <div class="filters">
                    </div>
                    <table>
                        <thead>
                            <tr>

                                <th>Date</th>
                                <th>Name</th>
                                <th class = "hide">Time In</th>
                                <th class = "hide">Time Out</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentActivity as $activity)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($activity->date)->format('Y-m-d') }}</td>
                                    <td>{{ $activity->name }}</td>
                                    <td class="hide">
                                        {{ $activity->time_in ? \Carbon\Carbon::parse($activity->time_in)->format('h:i A') : '-' }}
                                    </td>
                                    <td class="hide">
                                        {{ $activity->time_out ? \Carbon\Carbon::parse($activity->time_out)->format('h:i A') : '-' }}
                                    </td>
                                    <td>{{ $activity->status }}</td>
                                </tr>
                            @endforeach
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
    <script>
        const labels = @json($labels);
        const onTimeData = @json(array_values($onTimeData)); // convert to indexed arrays
        const lateData = @json(array_values($lateData));
        const absentData = @json(array_values($absentData));
    </script>
    <script src="{{ url('JS/dashchart.js') }}"></script>


    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>
