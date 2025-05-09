async function saveEmployee(event) {
    event.preventDefault();

    // Get form values
    const id = document.getElementById('employeeId').value;
    const name = document.getElementById('name').value;
    const age = document.getElementById('age').value;
    const gender = document.getElementById('gender').value;
    const position = document.getElementById('position').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const salary = document.getElementById('salary').value;
    const contactno = document.getElementById('contactno').value;
    const type = document.getElementById('type').value;

    // Validate input fields
    if (!name || !age || !gender || !position || !salary || !contactno || !type || (!email && !id) || (!password && !id)) {
        alert('Please fill out all required fields.');
        return;
    }

    const isEdit = Boolean(id);
    const employeeData = { name, age, gender, position, salary, contactno, type };

    if (!isEdit) {
        employeeData.email = email;
        employeeData.password = password;
    }

    const url = isEdit
        ? `http://127.0.0.1:8000/employees/edit/${id}`
        : 'http://127.0.0.1:8000/employees/add';
    const method = isEdit ? 'PATCH' : 'POST';

    try {
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

        const result = await response.json();

        if (result.success) {
            if (isEdit) {
                const rows = document.querySelectorAll('#employeeBody tr');
                rows.forEach(row => {
                    if (row.cells[1].innerText === id) {
                        row.cells[2].innerText = email;
                        row.cells[3].innerText = name;
                        row.cells[4].innerText = age;
                        row.cells[5].innerText = gender;
                        row.cells[6].innerText = contactno;
                        row.cells[7].innerText = type;
                        row.cells[8].innerText = position;
                    }
                });
            } else {
                const table = document.getElementById('employeeBody');
                const newRow = table.insertRow();

                // QR Code Button
                const qrCell = newRow.insertCell(0);
                const qrButton = document.createElement('button');
                qrButton.innerText = 'Show QR';
                qrButton.className = 'add-btn';
                qrButton.onclick = () => showQrModal(result.employee);
                qrCell.appendChild(qrButton);

                newRow.insertCell(1).innerText = result.employee.id;
                newRow.insertCell(2).innerText = email;
                newRow.insertCell(3).innerText = name;
                newRow.insertCell(4).innerText = age;
                newRow.insertCell(5).innerText = gender;
                newRow.insertCell(6).innerText = contactno;
                newRow.insertCell(7).innerText = type;
                newRow.insertCell(8).innerText = position;

                // Status Button
                const statusCell = newRow.insertCell(9);
                const statusBtn = document.createElement('button');
                statusBtn.className = 'status-btn active';
                statusBtn.innerText = 'Active';
                statusBtn.onclick = function () {
                    toggleStatus(statusBtn);
                };
                statusCell.appendChild(statusBtn);

                // Edit Button
                const editCell = newRow.insertCell(10);
                const editBtn = document.createElement('button');
                editBtn.className = 'edit-btn';
                editBtn.innerHTML = '<i class="fas fa-edit"></i>';
                editBtn.onclick = function () {
                    openEditModal(result.employee.id);
                };
                editCell.appendChild(editBtn);
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

let editingRow = null;

function openAddModal() {
    document.getElementById('modalTitle').innerText = "Add Employee";
    document.getElementById('employeeModal').style.display = 'flex';
    document.getElementById('employeeForm').reset();

    const passwordField = document.getElementById('password');
    const passwordContainer = document.getElementById('passwordContainer');
    passwordContainer.style.display = 'block';
    passwordField.required = true;

    editingRow = null;

    const passwordButton = document.getElementById('editPasswordButton');
    passwordButton.style.display = 'none';    
}

document.getElementById('editPasswordButton').addEventListener('click', () => {
    const passwordField = document.getElementById('password');
    const passwordContainer = document.getElementById('passwordContainer');
    
    // Show password field and make it required
    passwordContainer.style.display = 'block';
    passwordField.required = true;
});

async function openEditModal(id) {
    const passwordButton = document.getElementById('editPasswordButton');
    passwordButton.style.display = 'block';    
    document.getElementById('modalTitle').innerText = "Edit Employee";
    document.getElementById('employeeModal').style.display = 'flex';
    try {
        const response = await fetch('http://127.0.0.1:8000/employees');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const employees = await response.json();

        const employee = employees.find(emp => emp.id.toString() === id.toString());
        if (employee) {
            document.getElementById('employeeId').value = employee.id;
            document.getElementById('email').value = employee.email;
            document.getElementById('name').value = employee.name;
            document.getElementById('age').value = employee.age;
            document.getElementById('salary').value = employee.salary;
            document.getElementById('gender').value = employee.gender;
            document.getElementById('position').value = employee.position;
            document.getElementById('contactno').value = employee.contactno;
            document.getElementById('type').value = employee.type;

            // Hide password field and disable required by default
            const passwordField = document.getElementById('password');
            const passwordContainer = document.getElementById('passwordContainer');
            passwordField.required = false;
            passwordField.value = ''; // Clear any previous value
            passwordContainer.style.display = 'none';
        } else {
            console.error(`Employee with ID ${id} not found.`);
        }
    } catch (error) {
        console.error('Error fetching employees:', error);
    }
}

function closeEmployeeModal() {
    document.getElementById('employeeModal').style.display = 'none';
    editingRow = null;
}

async function generateQRCode(event) {
    event.preventDefault();

    const csrfToken = document.getElementById('csrf-token').value;
    const id = document.getElementById('employeeId').value;
    const name = document.getElementById('name').value;
    const age = document.getElementById('age').value;
    const gender = document.getElementById('gender').value;
    const position = document.getElementById('position').value;
    const contactno = document.getElementById('contactno').value;
    const type = document.getElementById('type').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const salary = document.getElementById('salary').value;

    if (!name || !age || !gender || !position || !email || (!password && !id) || !salary || !contactno || !type) {
        alert('Please fill out all required fields.');
        return;
    }

    const employeeData = { name, age, gender, position, email, salary, contactno, type };
    if (!id) {
        employeeData.password = password;
    }

    const isEdit = Boolean(id);
    const url = isEdit
        ? `http://127.0.0.1:8000/employees/${id}`
        : 'http://127.0.0.1:8000/employees/add';
    const method = isEdit ? 'PATCH' : 'POST';

    try {
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
            if (!isEdit) {
                const table = document.getElementById('employeeBody');
                const newRow = table.insertRow();

                // QR Button
                const qrCell = newRow.insertCell(0);
                const qrButton = document.createElement('button');
                qrButton.innerText = 'Show QR';
                qrButton.className = 'add-btn';
                qrButton.onclick = () => showQrModal(result.employee);
                qrCell.appendChild(qrButton);

                // Employee Info
                newRow.insertCell(1).innerText = result.employee.id;
                newRow.insertCell(2).innerText = email;
                newRow.insertCell(3).innerText = name;
                newRow.insertCell(4).innerText = age;
                newRow.insertCell(5).innerText = gender;
                newRow.insertCell(6).innerText = contactno;
                newRow.insertCell(7).innerText = type;
                newRow.insertCell(8).innerText = position;

                // Status
                const statusCell = newRow.insertCell(9);
                const statusBtn = document.createElement('button');
                statusBtn.className = 'status-btn active';
                statusBtn.innerText = 'Active';
                statusBtn.onclick = () => toggleStatus(statusBtn);
                statusCell.appendChild(statusBtn);

                // Edit
                const editCell = newRow.insertCell(10);
                const editBtn = document.createElement('button');
                editBtn.className = 'edit-btn';
                editBtn.innerHTML = '<i class="fas fa-edit"></i>';
                editBtn.onclick = () => openEditModal(result.employee.id);
                editCell.appendChild(editBtn);
            }

            document.getElementById('employeeForm').reset();
            closeEmployeeModal();
            alert(`Employee ${isEdit ? 'updated' : 'added'} successfully!`);
        } else {
            alert(`Failed to ${isEdit ? 'update' : 'add'} employee. Please try again.`);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while saving the employee.');
    }
}

function showQrModal(employee) {
    const modal = document.getElementById('qrModal');
    const qrContainer = document.getElementById('qrCodeContainer');
    qrContainer.innerHTML = '';

    new QRCode(qrContainer, {
        text: `ID: ${employee.id}\nName: ${employee.name}\nAge: ${employee.age}\nGender: ${employee.gender}\nPosition: ${employee.position}\nContact No: ${employee.contactno}\nType: ${employee.type}`,
        width: 500,
        height: 500,
    });

    modal.style.display = 'flex';

    setTimeout(() => {
        const img = qrContainer.querySelector('img');
        document.getElementById('downloadQrBtn').onclick = () => {
            const a = document.createElement('a');
            a.href = img.src;
            a.download = `EmployeeQR-${employee.name}.png`;
            a.click();
        };
    }, 500);
}

function closeQrModal() {
    document.getElementById('qrModal').style.display = 'none';
    document.getElementById('qrCodeContainer').innerHTML = '';
}

async function loadEmployees() {
    try {
        const response = await fetch('http://127.0.0.1:8000/employees');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const employees = await response.json();
        const tableBody = document.getElementById('employeeBody');
        employees.forEach(employee => {
            const newRow = tableBody.insertRow();

            // QR Button
            const qrCell = newRow.insertCell(0);
            const qrButton = document.createElement('button');
            qrButton.innerText = 'Show QR';
            qrButton.className = 'add-btn';
            qrButton.onclick = () => showQrModal(employee);
            qrCell.appendChild(qrButton);

            newRow.insertCell(1).textContent = employee.id;
            newRow.insertCell(2).textContent = employee.email;
            newRow.insertCell(3).textContent = employee.name;
            newRow.insertCell(4).textContent = employee.age;
            newRow.insertCell(5).textContent = employee.gender;
            newRow.insertCell(6).textContent = employee.contactno;
            newRow.insertCell(7).textContent = employee.type;
            newRow.insertCell(8).textContent = employee.position;

            // Status
            const statusCell = newRow.insertCell(9);
            statusCell.innerHTML = `<button class="status-btn active">Active</button>`;

            // Edit
            const editCell = newRow.insertCell(10);
            editCell.innerHTML = `
                <button class="edit-btn" onclick="openEditModal('${employee.id}')">
                    <i class="fas fa-edit"></i>
                </button>`;
        });

    } catch (error) {
        console.error('Error fetching employees:', error);
    }
}

function updateSalary() {
    const employeeType = document.getElementById('type').value;
    const salaryField = document.getElementById('salary');

    if (employeeType === "Regular") {
        salaryField.value = 86.31;
    } else if (employeeType === "Part-timer") {
        salaryField.value = 56.86;
    } else {
        salaryField.value = ""; // Clear the field if no type is selected
    }
}

window.onload = loadEmployees;
 