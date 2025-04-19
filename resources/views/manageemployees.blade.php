<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employee Management</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <link rel="stylesheet" href="{{ url('CSS/manemp.css') }}" />
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
                    <a href="/manage-employees">
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
                <h4>{{auth()->user()->name}}</h4>
            </div>
            
            <div class="user">
                <img src="{{ url('img/usericon.svg') }}" alt="">
            </div>
        </div>

        <div class="main-content">
            <!-- Add employee modal -->
            <div class="controls">
                <div>
                <button class="add-btn" onclick="openAddModal()">
  <i class="fas fa-user-plus"></i> Add Employee
</button>

<button class="addsched-btn" onclick="openScheduleModal()">
  <i class="fas fa-calendar-plus"></i> Add Schedule
</button>
                </div>

                <div class="filter-group">
                    
                <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search name" onkeyup="filterTable()" />
          <i class="fas fa-search"></i>
</div>


                      
                    <select id="positionFilter" onchange="filterTable()">
                        <option value="">All Positions</option>
                        <option value="Barista">Barista</option>
                        <option value="Kitchen Staff">Kitchen Staff</option>
                    </select>

                    <select id="employeeTypeFilter" onchange="filterTable()">
                        <option value="">All Types</option>
                        <option value="Regular">Regular</option>
                        <option value="Part-Timer">Part-Timer</option>
                    </select>

                   
                 
           
                    <div class="filter-group">
                        <select id="statusFilter" onchange="filterTable()">
                            <option value="">All Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Employee Table -->
            <div class="employee-table">
                <h2>Employee Information</h2>
                <table id="employeeTable">
                    <thead>
                        <tr>
                            <th>QR Code</th>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Contact No.</th>
                            <th>Employee Type</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Edit Details</th>
                        </tr>
                    </thead>
                    <tbody id="employeeBody">
                        <!-- Employee rows will be inserted here by JavaScript -->
                    </tbody>
                </table>

                <div class="pagination">
                    <button id="prevPage" onclick="changePage(-1)" disabled>
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                    <span id="pageNumber">Page 1</span>
                    <button id="nextPage" onclick="changePage(1)">
                        Next <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Modal for Add/Edit Employee -->
            <div class="modal" id="employeeModal">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeEmployeeModal()">&times;</span>
                    <h2 id="modalTitle">Add Employee</h2>
                    <form id="employeeForm" onsubmit="generateQRCode(event)">
                        @csrf
                        <input type="hidden" id="employeeId" name="employeeId">
                        <input type="hidden" id="csrf-token" value="{{ csrf_token() }}">
                        <input type="email" id="email" placeholder="Email" required />
                        <div class="password-field">
                            <input type="password" id="password" placeholder="Password" required />
                        </div>

                        <input type="text" id="name" placeholder="Name" required />
                     <input type="text" id="contactnum" name="contact_number" placeholder="Contact Number" required />
                        <input type="number" id="age" placeholder="Age" required />
                        <input type="number" id="salary" placeholder="Salary" required />

                        <div class="agegen">
                <select id="type" name="employee_type" required>
                    <option value="">Employee Type</option>
                    <option value="regular">Regular</option>
                    <option value="part-timer">Part-Timer</option>
                </select>
                <select id="gender" name="gender" required>
                    <option value="">Gender</option>
                    <option value="female">Female</option>
                    <option value="male">Male</option>
                </select>
            </div>

                        <div class="possch">
                            <select id="position" required>
                                <option value="">Select Position</option>
                                <option value="Barista">Barista</option>
                                <option value="Kitchen Staff">Kitchen Staff</option>
                            </select>

                            <select id="schedule" name="schedule" required>
                                <option value="">Schedule</option>
                                <option value="Shift 1">Shift 1</option>
                                <option value="Shift 2">Shift 2</option>
                            </select>
                       </div>

                        <button type="submit">Save</button>
                    </form>
                </div>
            </div>

             <!-- Modal for add schedule -->
             <div class="modal" id="ScheduleModal">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeScheduleModal()">&times;</span>
                    <h2 id="modalTitle">Add Schedule</h2>
                    <form id="scheduleForm">
                @csrf

                <br>
                <label>Select Day(s):</label>    <br>
             

                <div>
                    <label><input type="checkbox" name="Day[]" value="Monday"> Monday</label><br>
                    <label><input type="checkbox" name="Day[]" value="Tuesday"> Tuesday</label><br>
                    <label><input type="checkbox" name="Day[]" value="Wednesday"> Wednesday</label><br>
                    <label><input type="checkbox" name="Day[]" value="Thursday"> Thursday</label><br>
                    <label><input type="checkbox" name="Day[]" value="Friday"> Friday</label><br>
                    <label><input type="checkbox" name="Day[]" value="Saturday"> Saturday</label><br>
                    <label><input type="checkbox" name="Day[]" value="Sunday"> Sunday</label>
                </div><br>

                <label for="StartTime">Start Time:</label>
                <input type="time" id="StartTime" name="StartTime" required> 

                <label for="EndTime">End Time:</label>
                <input type="time" id="EndTime" name="EndTime" required>

                <select id="Shift" name="Shift" required>
                    <option value="">Select Shift</option>
                    <option value="Shift 1">Shift 1</option>
                    <option value="Shift 2">Shift 2</option>
                </select><br><br>

                <button type="submit">Save</button>
            </form>
    
        </div>

            <script src="{{ url('JS/manemp.js') }}"></script>
            <script src="{{ url('JS/sidebar.js') }}"></script>

            <script>
                // Filtering Function
                function filterTable() {
                    const searchInput = document.getElementById('searchInput').value.toLowerCase();
                    const positionFilter = document.getElementById('positionFilter').value.toLowerCase();
                    const employeeTypeFilter = document.getElementById('employeeTypeFilter').value.toLowerCase();
                    const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
                    const employeeTable = document.getElementById('employeeTable');
                    const rows = employeeTable.getElementsByTagName('tr');  // Get all table rows

                    // Loop through the rows, skipping the header row
                    for (let i = 1; i < rows.length; i++) {
                        let row = rows[i];
                        let nameCell = row.cells[2].textContent.toLowerCase();  // Name column
                        let positionCell = row.cells[7].textContent.toLowerCase();  // Position column
                        let employeeTypeCell = row.cells[6].textContent.toLowerCase();  // Employee Type column
                        let statusCell = row.cells[8].textContent.toLowerCase();  // Status column

                        // Check if row matches search and filter criteria
                        let matchesSearch = nameCell.includes(searchInput);
                        let matchesPosition = positionCell.includes(positionFilter);
                        let matchesEmployeeType = employeeTypeCell.includes(employeeTypeFilter);
                        let matchesStatus = statusCell.includes(statusFilter);

                        // Show or hide row based on filters
                        if (matchesSearch && matchesPosition && matchesEmployeeType && matchesStatus) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                }
            </script>
        </div>
    </div>

</body>

</html>
