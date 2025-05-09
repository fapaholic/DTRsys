 // Sample employee DTR data for a month (you can fetch this from your backend)
 const dtrData = {
    'Sheina Labadan': {
        'March': [{
                date: '03/01/2025',
                timeInAM: '8:30',
                timeOutAM: '12:00',
                timeInPM: '1:00',
                timeOutPM: '5:30',
                workingHours: '8 hours',
                status: 'On Time',
                deductions: 50,
                salary: 300
            },
            {
                date: '03/02/2025',
                timeInAM: '8:40',
                timeOutAM: '12:10',
                timeInPM: '1:05',
                timeOutPM: '5:40',
                workingHours: '8 hours',
                status: 'On Time',
                deductions: 50,
                salary: 300
            },
            {
                date: '03/03/2025',
                timeInAM: '8:35',
                timeOutAM: '12:05',
                timeInPM: '1:00',
                timeOutPM: '5:30',
                workingHours: '8 hours',
                status: 'On Time',
                deductions: 50,
                salary: 300
            },
            {
                date: '03/04/2025',
                timeInAM: '8:25',
                timeOutAM: '12:00',
                timeInPM: '1:10',
                timeOutPM: '5:30',
                workingHours: '8 hours',
                status: 'On Time',
                deductions: 50,
                salary: 300
            },
            {
                date: '03/05/2025',
                timeInAM: '8:45',
                timeOutAM: '12:15',
                timeInPM: '1:00',
                timeOutPM: '5:40',
                workingHours: '8 hours',
                status: 'On Time',
                deductions: 50,
                salary: 300
            },
            {
                date: '03/06/2025',
                timeInAM: '8:30',
                timeOutAM: '12:00',
                timeInPM: '1:05',
                timeOutPM: '5:35',
                workingHours: '8 hours',
                status: 'On Time',
                deductions: 50,
                salary: 300
            }
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

function filterTable() {
    const nameInput = document.getElementById("searchName").value.toLowerCase();
    const dateInput = document.getElementById("searchDate").value;
    const positionInput = document.getElementById("positionFilter").value.toLowerCase();
    const typeInput = document.getElementById("typeFilter").value.toLowerCase();

    const table = document.getElementById("myTable");
    const tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        const tdName = tr[i].getElementsByTagName("td")[1];
        const tdDate = tr[i].getElementsByTagName("td")[0];
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

let currentEmployee = '';
            let currentMonth = '';
            let currentYear = '';

            function closeModal() {
                document.getElementById("dtrModal").style.display = "none";
            }

            function getMonthNumber(monthName) {
                const months = {
                    January: "01",
                    February: "02",
                    March: "03",
                    April: "04",
                    May: "05",
                    June: "06",
                    July: "07",
                    August: "08",
                    September: "09",
                    October: "10",
                    November: "11",
                    December: "12"
                };
                return months[monthName] || "";
            }

            function getMonthName(monthNumber) {
                const months = {
                    "01": "January",
                    "02": "February",
                    "03": "March",
                    "04": "April",
                    "05": "May",
                    "06": "June",
                    "07": "July",
                    "08": "August",
                    "09": "September",
                    "10": "October",
                    "11": "November",
                    "12": "December"
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