function generateQRCode(event) {
    event.preventDefault();

    // Get form values
    const name = document.getElementById('name').value;
    const age = document.getElementById('age').value;
    const gender = document.getElementById('gender').value;
    const position = document.getElementById('position').value;

    // Combine the data into a string format
    const qrData = `Name: ${name}\nAge: ${age}\nGender: ${gender}\nPosition: ${position}\n`;

    // Clear previous QR code if exists
    document.getElementById('qrcode').innerHTML = '';

    // Generate the QR code
    new QRCode(document.getElementById('qrcode'), {
        text: qrData,
        width: 128,
        height: 128
    });
}

function openAddModal() {
    document.getElementById('modalTitle').innerText = "Add Employee";
    document.getElementById('employeeModal').style.display = 'flex';
    document.getElementById('employeeModal').style.justifyContent = 'center';
    document.getElementById('employeeModal').style.display = 'flex';
    

    // Clear form fields
    document.getElementById('employeeForm').reset();
}


function openScheduleModal() {
    document.getElementById('modalTitle').innerText = "Add Schedule";
    document.getElementById('ScheduleModal').style.display = 'flex';
    document.getElementById('ScheduleModal').style.justifyContent = 'center';
    document.getElementById('ScheduleModal').style.display = 'flex';
    

    // Clear form fields
    document.getElementById('employeeForm').reset();
}

function closeEmployeeModal() {
    document.getElementById('employeeModal').style.display = 'none';
    
}

function closeScheduleModal() {
    document.getElementById('ScheduleModal').style.display = 'none';
    
}

async function saveEmployee(event) {
    event.preventDefault();

    // Get form values
    const id = document.getElementById('employeeId').value; // Hidden field for ID (used for editing)
    const name = document.getElementById('name').value;
    const age = document.getElementById('age').value;
    const gender = document.getElementById('gender').value;
    const position = document.getElementById('position').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const salary = document.getElementById('salary').value;

    // Validate input fields
    if (!name || !age || !gender || !position || !salary || (!email && !id) || (!password && !id)) {
        alert('Please fill out all required fields.');
        return;
    }

    // Determine if this is an Add or Edit operation
    const isEdit = Boolean(id); // If `id` exists, it's an edit
    const employeeData = { name, age, gender, position, salary };

    // Add `email` and `password` only for new employees
    if (!isEdit) {
        employeeData.email = email;
        employeeData.password = password;
    }

    // Construct URL and method
    const url = isEdit
        ? `http://127.0.0.1:8000/employees/edit/${id}` // Replace with your actual edit endpoint
        : 'http://127.0.0.1:8000/employees/add';
    const method = isEdit ? 'PATCH' : 'POST';

    try {
        // Send the employee data to the backend
        const response = await fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(employeeData),
        });

        if (!response.ok) {
            throw new Error(`Failed to ${isEdit ? 'update' : 'add'} employee: ${response.statusText}`);
        }

        // Parse the response
        const result = await response.json();

        if (result.success) {
            if (isEdit) {
                // Update the row in the table for edits
                const rows = document.querySelectorAll('#employeeBody tr');
                rows.forEach(row => {
                    if (row.cells[0].innerText === id) { // Assuming ID is in cell index 0
                        row.cells[1].innerText = name; // Name
                        row.cells[2].innerText = age; // Age
                        row.cells[3].innerText = gender; // Gender
                        row.cells[4].innerText = position; // Position
                        row.cells[5].innerText = salary; // Salary
                    }
                });
            } else {
                // Add a new row for additions
                const table = document.getElementById('employeeBody');
                const newRow = table.insertRow();
                newRow.insertCell(0).innerText = result.employee.id; // ID
                newRow.insertCell(1).innerText = name; // Name
                newRow.insertCell(2).innerText = age; // Age
                newRow.insertCell(3).innerText = gender; // Gender
                newRow.insertCell(4).innerText = position; // Position
                newRow.insertCell(5).innerText = salary; // Salary
                newRow.insertCell(6).innerHTML = `
                    <button class="edit-btn" onclick="openEditModal('${result.employee.id}')">Edit</button>
                `;
            }

            closeEmployeeModal();
            alert(`Employee successfully ${isEdit ? 'updated' : 'added'}!`);
        } else {
            alert(`Failed to ${isEdit ? 'update' : 'add'} employee. Please try again.`);
        }
    } catch (error) {
        console.error('Error:', error);
        alert(`An error occurred while ${isEdit ? 'updating' : 'adding'} the employee.`);
    }
}


function closeModal() {
    document.getElementById('scheduleModal').style.display = 'none';
}

// Filter Function
function filterTable() {
    const searchValue = document.getElementById('searchInput').value.toLowerCase();
    const positionFilter = document.getElementById('positionFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('#employeeBody tr');

    rows.forEach(row => {
        const name = row.cells[0].innerText.toLowerCase();
        const position = row.cells[3].innerText;
        const status = row.cells[4].querySelector('button').innerText;

        const matchesSearch = name.includes(searchValue) || searchValue === "";
        const matchesPosition = position === positionFilter || positionFilter === "";
        const matchesStatus = status === statusFilter || statusFilter === "";

        if (matchesSearch && matchesPosition && matchesStatus) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

// Toggle Active/Inactive
function toggleStatus(button) {
    if (button.classList.contains('active')) {
        button.classList.remove('active');
        button.classList.add('inactive');
        button.innerText = 'Inactive';
    } else {
        button.classList.remove('inactive');
        button.classList.add('active');
        button.innerText = 'Active';
    }
}

// Open Modal for Adding Employee
function openAddModal() {
    document.getElementById('modalTitle').innerText = "Add Employee";
    document.getElementById('employeeModal').style.display = 'flex';
}

function closeEmployeeModal() {
    document.getElementById('employeeModal').style.display = 'none';
    
}

// Open Modal for Editing Employee


function generateQRCode(event) {
    event.preventDefault();

    // Get form values

    const name = document.getElementById('name').value;
    const age = document.getElementById('age').value;
    const gender = document.getElementById('gender').value;
    const position = document.getElementById('position').value;

    // Create a new table row
    const table = document.getElementById('employeeBody');
    const newRow = table.insertRow();

    // Insert table data cells

    newRow.insertCell(1).textContent = id;
    newRow.insertCell(2).textContent = name;
    newRow.insertCell(3).textContent = age;
    newRow.insertCell(4).textContent = gender;
    newRow.insertCell(5).textContent = `0912345678`;
    newRow.insertCell(6).textContent = `Regular`;
    newRow.insertCell(7).textContent = position;

    // Status cell
    const statusCell = newRow.insertCell(8);
    const statusBtn = document.createElement('button');
    statusBtn.className = 'status-btn active';
    statusBtn.textContent = 'Active';
    statusBtn.onclick = function () {
        toggleStatus(statusBtn);
    };
    statusCell.appendChild(statusBtn);

    // QR Code cell
    const qrCell = newRow.insertCell(0);
    const qrDiv = document.createElement('div');
    qrDiv.id = `qrcode-${name.replace(/\s+/g, '-')}`; // Unique ID for QR Code
    qrCell.appendChild(qrDiv);

    new QRCode(qrDiv, {
        text: `ID: ${id}\nName: ${name}\nAge: ${age}\nGender: ${gender}\nPosition: ${position}\n`,
        width: 80,
        height: 80
    });

    // Edit button
    const editCell = newRow.insertCell(7);
    const editBtn = document.createElement('button');
    editBtn.className = 'edit-btn';
    editBtn.innerHTML = '<i class="fas fa-edit"></i>';
    editBtn.onclick = function () {
        openEditModal(id);
    };
    editCell.appendChild(editBtn);

    // Clear form after submission
    document.getElementById('employeeForm').reset();
    closeEmployeeModal();
}

// Toggle status function
function toggleStatus(button) {
    if (button.classList.contains('active')) {
        button.classList.remove('active');
        button.classList.add('inactive');
        button.textContent = 'Inactive';
    } else {
        button.classList.remove('inactive');
        button.classList.add('active');
        button.textContent = 'Active';
    }
}


// Close modal
function closeEmployeeModal() {
    document.getElementById('employeeModal').style.display = 'none';
    
}

let editingRow = null; // Keep track of the row being edited

// Open Modal for Adding Employee
function openAddModal() {
    document.getElementById('modalTitle').innerText = "Add Employee";
    document.getElementById('employeeModal').style.display = 'flex';

    // Clear form fields and reset editingRow
    document.getElementById('employeeForm').reset();
    editingRow = null;
}

// Open Modal for Editing Employee
async function openEditModal(id) {
    document.getElementById('modalTitle').innerText = "Edit Employee";
    document.getElementById('employeeModal').style.display = 'flex';

    

    try {
        // Fetch employee data from the server
        const response = await fetch('http://127.0.0.1:8000/employees');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const employees = await response.json();

        // Find the specific employee based on the ID
        const employee = employees.find(emp => emp.name.toString() === id.toString());

        if (employee) {
            // Fill modal fields with existing data
            document.getElementById('employeeId').value = employee.id; // Hidden field for ID
            document.getElementById('email').value = employee.email;
            document.getElementById('name').value = employee.name; // Name
            document.getElementById('age').value = employee.age; // Age
            document.getElementById('salary').value = employee.salary;
            document.getElementById('gender').value = employee.gender; // Gender
            document.getElementById('position').value = employee.position; // Position
        } else {
            console.error(`Employee with ID ${name} not found.`);
        }
    } catch (error) {
        console.error('Error fetching employees:', error);
    }
}


// Close Modal
function closeEmployeeModal() {
    document.getElementById('employeeModal').style.display = 'none';
    editingRow = null;
}

function togglePasswordVisibility() {
    const passwordField = document.getElementById('password');
    const toggleButton = document.getElementById('togglePassword');
    const isPasswordVisible = passwordField.type === 'text';

    // Toggle password visibility
    passwordField.type = isPasswordVisible ? 'password' : 'text';

    // Change the icon
    toggleButton.innerHTML = isPasswordVisible
        ? '<ion-icon name="eye-outline"></ion-icon>' // Eye icon
        : '<ion-icon name="eye-off-outline"></ion-icon>'; // Eye-slash icon
}


async function generateQRCode(event) {
    event.preventDefault();

    // Get form values
    const csrfToken = document.getElementById('csrf-token').value;
    const id = document.getElementById('employeeId').value; // Hidden field for ID (used for editing)
    const name = document.getElementById('name').value;
    const age = document.getElementById('age').value;
    const gender = document.getElementById('gender').value;
    const position = document.getElementById('position').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const salary = document.getElementById('salary').value;

    // Validate input fields
    if (!name || !age || !gender || !position || !email || (!password && !id) || !salary) {
        alert('Please fill out all required fields.');
        return;
    }

    

    // Prepare the employee data object
    const employeeData = { name, age, gender, position, email, salary };
    if (!id) {
        // Include password only when adding a new employee
        employeeData.password = password;
    }

    // Determine whether this is an add (POST) or edit (PATCH) operation
    const isEdit = Boolean(id);
    const url = isEdit
        ? `http://127.0.0.1:8000/employees/${id}` // Replace with your actual edit endpoint
        : 'http://127.0.0.1:8000/employees/add';
    const method = isEdit ? 'PATCH' : 'POST';

    try {
        // Send the employee data to the backend
        const response = await fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(employeeData),
        });

        if (!response.ok) {
            throw new Error(`Failed to ${isEdit ? 'update' : 'add'} employee: ${response.statusText}`);
        }

        const result = await response.json();

        if (result.success) {
            if (isEdit) {
                // Update the row in the table for edits
                const rows = document.querySelectorAll('#employeeBody tr');
                rows.forEach(row => {
                    if (row.cells[1].innerText === id) { // Assuming ID is in cell index 1
                        row.cells[2].innerText = name;
                        row.cells[3].innerText = age;
                        row.cells[4].innerText = gender;
                        row.cells[5].innerText = position;
                    }
                });
                alert('Employee updated successfully!');
            } else {
                // Add a new row for additions
                const table = document.getElementById('employeeBody');
                const newRow = table.insertRow();

                // QR Code Cell
                const qrCell = newRow.insertCell(0);
                const qrDiv = document.createElement('div');
                qrCell.appendChild(qrDiv);
                new QRCode(qrDiv, {
                    text: `Name: ${result.employee.name}\nAge: ${result.employee.age}\nGender: ${result.employee.gender}\nPosition: ${result.employee.position}`,
                    width: 80,
                    height: 80,
                });

                // Insert other cells
                newRow.insertCell(1).innerText = result.employee.id;
                newRow.insertCell(2).innerText = result.employee.name;
                newRow.insertCell(3).innerText = result.employee.age;
                newRow.insertCell(4).innerText = result.employee.gender;
                newRow.insertCell(5).textContent = `0912345678`;
                newRow.insertCell(6).textContent = `Regular`;
                newRow.insertCell(7).innerText = result.employee.position;

                // Status Button
                const statusCell = newRow.insertCell(8);
                const statusBtn = document.createElement('button');
                statusBtn.className = 'status-btn active';
                statusBtn.innerText = 'Active';
                statusBtn.onclick = function () {
                    toggleStatus(statusBtn);
                };
                statusCell.appendChild(statusBtn);

                // Edit Button
                const editCell = newRow.insertCell(9);
                const editBtn = document.createElement('button');
                editBtn.className = 'edit-btn';
                editBtn.innerHTML = '<i class="fas fa-edit"></i>';
                editBtn.onclick = function () {
                    openEditModal(result.employee.id);
                };
                editCell.appendChild(editBtn);

                alert('Employee added successfully!');
            }

            // Clear form and close modal
            document.getElementById('employeeForm').reset();
            closeEmployeeModal();
        } else {
            alert(`Failed to ${isEdit ? 'update' : 'add'} employee. Please try again.`);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while saving the employee.');
    }
}

// Toggle Active/Inactive Status
function toggleStatus(button) {
    if (button.classList.contains('active')) {
        button.classList.remove('active');
        button.classList.add('inactive');
        button.innerText = 'Inactive';
    } else {
        button.classList.remove('inactive');
        button.classList.add('active');
        button.innerText = 'Active';
    }
}

async function loadEmployees() {
    try {
        const response = await fetch('http://127.0.0.1:8000/employees');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const employees = await response.json();
        console.log(employees); // Log the data to verify

        const tableBody = document.getElementById('employeeBody');
        employees.forEach(employee => {
            const newRow = tableBody.insertRow();
            const qrCell = newRow.insertCell(0);
            const qrDiv = document.createElement('div');
            qrCell.appendChild(qrDiv);
            newRow.insertCell(1).textContent = employee.id;
            newRow.insertCell(2).textContent = employee.name;
            newRow.insertCell(3).textContent = employee.age;
            newRow.insertCell(4).textContent = employee.gender;
            newRow.insertCell(5).textContent = `0912345678`;
            newRow.insertCell(6).textContent = `Regular`;
            newRow.insertCell(7).textContent = employee.position;
            const statusCell = newRow.insertCell(8);
            statusCell.innerHTML = `<button class="status-btn active">Active</button>`;



            new QRCode(qrDiv, {
                text: `ID: ${employee.id}\nName: ${employee.name}\nAge: ${employee.age}\nGender: ${employee.gender}\nPosition: ${employee.position}\n`,
                width: 80,
                height: 80
            });



            const editCell = newRow.insertCell(9);
            editCell.innerHTML = `
                    <button class="edit-btn" onclick="openEditModal('${employee.name}')">
                        <i class="fas fa-edit"></i>
                    </button>`;
        });
    } catch (error) {
        console.error('Error fetching employees:', error);
    }
}


// Call loadEmployees when the page loads
window.onload = loadEmployees;
