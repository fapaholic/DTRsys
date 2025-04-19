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
                    <h4>{{auth()->user()->name}}</h4>
                </div>
              
                <div class="user">
                    <img src="{{ url('img/usericon.svg') }}" alt="">
                </div>
            </div>

            <div class="main-content">
            <h2>April 1, 2025</h2>


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
                        <tr>
                            <td>03-24-2025</td>
                            <td>Benjamin Thompson</td>
                            <td>Barista</td>
                            <td>Part Time</td> 
                            <td>600.00</td>
                            <td>1,520.00</td>     
                            <td>1,400.00</td>
                            <td>1,400.00</td>
                            <td class="view-btn" onclick="openDtrModal('Sheina Labadan', 'March')"><i class="fas fa-eye"></i></td>


                        </tr>

                        <tr>
                            <td>03-24-2026</td>
                            <td>Emily Williams</td>
                            <td>Kitchen Staff</td>
                            <td>Regular</td>
                            <td>9,500.00</td>
                            <td>1,520.00</td>
                            <td>1,520.00</td>
                            <td>1,400.00</td>
                      
                            <td class="view-btn" onclick="openDtrModal('Sheina Labadan', 'March')"><i class="fas fa-eye"></i></td>


                        </tr>

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

            <div id="dtrModal" class="modal">
            <div class="modal-content">
                <!-- Close button positioned at top right corner -->
                 
                <span class="close-btn" onclick="closeModal()">&times;</span>

                <div class="main-content">
                <h3>Employee DTR for <span id="modalEmployeeName">Sheina Labadan</span> - Month of <span id="modalMonth">March</span></h3>

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




<script>
    // Sample employee DTR data for a month (you can fetch this from your backend)
    const dtrData = {
    'Sheina Labadan': {
        'March': [
            { date: '03/01/2025', timeInAM: '8:30', timeOutAM: '12:00', timeInPM: '1:00', timeOutPM: '5:30', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/02/2025', timeInAM: '8:40', timeOutAM: '12:10', timeInPM: '1:05', timeOutPM: '5:40', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/03/2025', timeInAM: '8:35', timeOutAM: '12:05', timeInPM: '1:00', timeOutPM: '5:30', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/04/2025', timeInAM: '8:25', timeOutAM: '12:00', timeInPM: '1:10', timeOutPM: '5:30', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/05/2025', timeInAM: '8:45', timeOutAM: '12:15', timeInPM: '1:00', timeOutPM: '5:40', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/06/2025', timeInAM: '8:30', timeOutAM: '12:00', timeInPM: '1:05', timeOutPM: '5:35', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/07/2025', timeInAM: '8:40', timeOutAM: '12:05', timeInPM: '1:00', timeOutPM: '5:30', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/08/2025', timeInAM: '8:30', timeOutAM: '12:00', timeInPM: '1:10', timeOutPM: '5:40', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/09/2025', timeInAM: '8:35', timeOutAM: '12:10', timeInPM: '1:00', timeOutPM: '5:30', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/10/2025', timeInAM: '8:40', timeOutAM: '12:00', timeInPM: '1:05', timeOutPM: '5:30', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/11/2025', timeInAM: '8:30', timeOutAM: '12:00', timeInPM: '1:00', timeOutPM: '5:30', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/12/2025', timeInAM: '8:45', timeOutAM: '12:10', timeInPM: '1:00', timeOutPM: '5:35', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/13/2025', timeInAM: '8:30', timeOutAM: '12:00', timeInPM: '1:05', timeOutPM: '5:30', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/14/2025', timeInAM: '8:30', timeOutAM: '12:00', timeInPM: '1:00', timeOutPM: '5:30', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/15/2025', timeInAM: '8:40', timeOutAM: '12:10', timeInPM: '1:05', timeOutPM: '5:40', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/16/2025', timeInAM: '8:35', timeOutAM: '12:05', timeInPM: '1:00', timeOutPM: '5:30', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/17/2025', timeInAM: '8:25', timeOutAM: '12:00', timeInPM: '1:10', timeOutPM: '5:40', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/18/2025', timeInAM: '8:30', timeOutAM: '12:00', timeInPM: '1:05', timeOutPM: '5:35', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/19/2025', timeInAM: '8:40', timeOutAM: '12:10', timeInPM: '1:00', timeOutPM: '5:30', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/20/2025', timeInAM: '8:30', timeOutAM: '12:00', timeInPM: '1:05', timeOutPM: '5:30', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/21/2025', timeInAM: '8:35', timeOutAM: '12:05', timeInPM: '1:00', timeOutPM: '5:30', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/22/2025', timeInAM: '8:30', timeOutAM: '12:00', timeInPM: '1:00', timeOutPM: '5:30', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/23/2025', timeInAM: '8:40', timeOutAM: '12:10', timeInPM: '1:05', timeOutPM: '5:40', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/24/2025', timeInAM: '8:30', timeOutAM: '12:00', timeInPM: '1:00', timeOutPM: '5:30', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/25/2025', timeInAM: '8:45', timeOutAM: '12:15', timeInPM: '1:00', timeOutPM: '5:35', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/26/2025', timeInAM: '8:30', timeOutAM: '12:00', timeInPM: '1:05', timeOutPM: '5:30', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/27/2025', timeInAM: '8:30', timeOutAM: '12:00', timeInPM: '1:00', timeOutPM: '5:30', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/28/2025', timeInAM: '8:40', timeOutAM: '12:10', timeInPM: '1:05', timeOutPM: '5:40', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/29/2025', timeInAM: '8:35', timeOutAM: '12:05', timeInPM: '1:00', timeOutPM: '5:30', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/30/2025', timeInAM: '8:25', timeOutAM: '12:00', timeInPM: '1:10', timeOutPM: '5:40', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 },
            { date: '03/31/2025', timeInAM: '8:30', timeOutAM: '12:00', timeInPM: '1:05', timeOutPM: '5:30', workingHours: '8 hours', status: 'On Time', deductions: 50, salary: 300 }
        ]
    }
};


let currentPage = 1;
const rowsPerPage = 15;

// Function to open the modal and display DTR data with pagination
function openDtrModal(employeeName, month) {
    // Get the modal and table body
    const modal = document.getElementById("dtrModal");
    const tableBody = document.getElementById("dtrTable").getElementsByTagName('tbody')[0];
    
    // Set modal title with employee name and month
    document.getElementById("modalEmployeeName").innerText = employeeName;
    document.getElementById("modalMonth").innerText = month;
    
    // Clear previous table rows
    tableBody.innerHTML = '';
    
    // Variables to calculate the net salary
    let totalSalary = 0;
    let totalDeductions = 0;

    // Fetch data for the selected employee and month
    const data = dtrData[employeeName] && dtrData[employeeName][month];
    
    // Paginate the data
    const totalPages = Math.ceil(data.length / rowsPerPage);
    const startIndex = (currentPage - 1) * rowsPerPage;
    const endIndex = startIndex + rowsPerPage;
    
    // Show the current page data
    const pageData = data.slice(startIndex, endIndex);
    
    // Populate the table with paginated data
    pageData.forEach(entry => {
        const row = tableBody.insertRow();
        row.insertCell(0).innerText = entry.date;
        row.insertCell(1).innerText = entry.timeInAM;
        row.insertCell(2).innerText = entry.timeOutAM;
        row.insertCell(3).innerText = entry.timeInPM;
        row.insertCell(4).innerText = entry.timeOutPM;
        row.insertCell(5).innerText = entry.workingHours;
        row.insertCell(6).innerText = entry.status;
        row.insertCell(7).innerText = entry.deductions;
        row.insertCell(8).innerText = entry.salary.toFixed(2);
        
        // Add to total salary and total deductions
        totalSalary += entry.salary;
        totalDeductions += entry.deductions;
    });
    
    // Calculate and display net salary
    const netSalary = totalSalary - totalDeductions;
    document.getElementById("netSalary").innerText = netSalary.toFixed(2);

    // Update pagination controls
    document.getElementById("pageIndicator").innerText = `Page ${currentPage} of ${totalPages}`;
    document.getElementById("prevPageBtn").disabled = currentPage === 1;
    document.getElementById("nextPageBtn").disabled = currentPage === totalPages;
    
    // Show the modal
    modal.style.display = "block";
}

// Function to change the page
function changePage(direction) {
    currentPage += direction;
    openDtrModal('Sheina Labadan', 'March'); // Reload data with new page
}

// Function to close the modal
function closeModal() {
    const modal = document.getElementById("dtrModal");
    modal.style.display = "none";
}

// Event listener for closing the modal if clicked outside
window.onclick = function(event) {
    const modal = document.getElementById("dtrModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Function to close the modal
function closeModal() {
    const modal = document.getElementById("dtrModal");
    modal.style.display = "none";
}

</script>

           


            <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
            <script src="{{ url('JS/sidebar.js') }}"></script>
            <script src="{{ url('JS/manemp.js') }}"></script>



            <!-- FILTER FUNCTION -->
<script>
function filterTable() {
  const nameInput = document.getElementById("searchName").value.toLowerCase();
  const dateInput = document.getElementById("searchDate").value;
  const positionInput = document.getElementById("positionFilter").value.toLowerCase();
  const typeInput = document.getElementById("typeFilter").value.toLowerCase();

  const table = document.getElementById("myTable");
  const tr = table.getElementsByTagName("tr");

  for (let i = 1; i < tr.length; i++) {
    const tdName = tr[i].getElementsByTagName("td")[0];
    const tdDate = tr[i].getElementsByTagName("td")[1];
    const tdPosition = tr[i].getElementsByTagName("td")[2];
    const tdType = tr[i].getElementsByTagName("td")[3];

    if (tdName && tdDate && tdPosition && tdType) {
      const name = tdName.textContent.toLowerCase();
      const date = tdDate.textContent;
      const position = tdPosition.textContent.toLowerCase();
      const type = tdType.textContent.toLowerCase();

      const nameMatch = name.includes(nameInput);
      const dateMatch = dateInput === "" || date === dateInput;
      const positionMatch = positionInput === "" || position === positionInput;
      const typeMatch = typeInput === "" || type === typeInput;

      if (nameMatch && dateMatch && positionMatch && typeMatch) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>


<!-- SA EYE MODAL -->
<script>
let currentEmployee = '';
let currentMonth = '';
let currentYear = '';

function openDtrModal(employeeName, month) {
    currentEmployee = employeeName;
    currentMonth = month;
    currentYear = document.getElementById("yearFilter").value || "2025"; // default year

    document.getElementById("modalEmployeeName").textContent = employeeName;
    document.getElementById("modalMonth").textContent = month;

    document.getElementById("monthFilter").value = getMonthNumber(month); // Set dropdown value
    document.getElementById("yearFilter").value = currentYear;

    filterDtrData(); // Display filtered data
    document.getElementById("dtrModal").style.display = "block";
}

function closeModal() {
    document.getElementById("dtrModal").style.display = "none";
}

function getMonthNumber(monthName) {
    const months = {
        January: "01", February: "02", March: "03", April: "04", May: "05", June: "06",
        July: "07", August: "08", September: "09", October: "10", November: "11", December: "12"
    };
    return months[monthName] || "";
}

function getMonthName(monthNumber) {
    const months = {
        "01": "January", "02": "February", "03": "March", "04": "April", "05": "May", "06": "June",
        "07": "July", "08": "August", "09": "September", "10": "October", "11": "November", "12": "December"
    };
    return months[monthNumber] || "";
}

function filterDtrData() {
    const month = document.getElementById("monthFilter").value;
    const year = document.getElementById("yearFilter").value;
    const tbody = document.querySelector("#dtrTable tbody");
    tbody.innerHTML = "";

    let totalSalary = 0;

    if (dtrData[currentEmployee]) {
        const selectedMonthName = getMonthName(month);
        document.getElementById("modalMonth").textContent = selectedMonthName;

        const records = dtrData[currentEmployee][selectedMonthName] || [];

        records.forEach(row => {
            const rowYear = row.date.split("/")[2];
            const rowMonth = row.date.split("/")[0];

            if (rowMonth === month && rowYear === year) {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${row.date}</td>
                    <td>${row.timeInAM}</td>
                    <td>${row.timeOutAM}</td>
                    <td>${row.timeInPM}</td>
                    <td>${row.timeOutPM}</td>
                    <td>${row.workingHours}</td>
                    <td>${row.status}</td>
                    <td>${row.deductions}</td>
                    <td>${row.salary}</td>
                `;
                tbody.appendChild(tr);

                totalSalary += row.salary;
            }
        });
    }

    document.getElementById("netSalary").textContent = totalSalary.toFixed(2);
}

// Bind filterDtrData to month/year dropdown changes
document.getElementById("monthFilter").addEventListener("change", filterDtrData);
document.getElementById("yearFilter").addEventListener("change", filterDtrData);
</script>

</body>

</html>
