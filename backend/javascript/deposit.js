// Fetch and display deposits on page load
document.addEventListener('DOMContentLoaded', fetchDeposits);

function fetchDeposits() {
    fetch('backend/php/get_deposits.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateDepositTable(data.deposits);
            } else {
                console.error('Failed to fetch deposits:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching deposits:', error);
        });
}

// Populate the deposits table
function populateDepositTable(deposits) {
    const tableBody = document.getElementById('table-body');
    tableBody.innerHTML = ''; // Clear existing rows

    deposits.forEach((deposit, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}.</td>
            <td>${deposit.date}</td>
            <td>${deposit.category}</td>
            <td>${deposit.description}</td>
            <td>₱${parseFloat(deposit.amount).toFixed(2)}</td>
            <input type="hidden" class="deposit-id" value="${deposit.id}">
            <td class="action-buttons">
                <button class="btn btn-warning btn-sm" onclick="editRow(this)">Edit</button>
                <button class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button>
            </td>
        `;
        tableBody.appendChild(row);
    });

    calculateTotal(); // Update total after populating the table
}


// Open the modal
function openDepositModal() {
    document.getElementById('deposit-modal').style.display = 'block';
}

function openEditDepositModal() {
    document.getElementById('edit-deposit-modal').style.display = 'block';
}

// Close the modal
function closeDepositModal() {
    document.getElementById('deposit-modal').style.display = 'none';
}

function closeEditDepositModal() {
    document.getElementById('edit-deposit-modal').style.display = 'none';
}

// Add a new deposit record to the table
let rowCount = 0;
function addDepositRecord(event) {
    event.preventDefault(); // Prevent form submission

    // Collect form data
    const description = document.getElementById('create_description').value;
    const date = document.getElementById('create_date').value;
    const category = document.getElementById('create_category').value;
    const amount = parseFloat(document.getElementById('create_amount').value);

    if (!description || !date || !category || isNaN(amount)) {
        console.error('One or more fields are empty or invalid');
        return;
    }

    // Send data to the server
    fetch('backend/php/create_deposit.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            description: description,
            date: date,
            category: category,
            amount: amount
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // Check the server response
        if (data.success) {
            const depositId = data.deposit_id; // Get the deposit_id from the server response
            rowCount++;
            const tableBody = document.getElementById('table-body');

            console.log('id:', depositId);

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${rowCount}.</td>
                <td>${description}</td>
                <td>${category}</td>
                <td>${date}</td>
                <td>₱${amount.toFixed(2)}</td>
                <input type="hidden" class="deposit-id" value="${depositId}">
                <td class="action-buttons">
                    <button class="btn btn-warning btn-sm" onclick="editRow(this)">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);

            calculateTotal(); // Update total after adding a new record

            // Clear the form and close the modal
            document.getElementById('deposit-form').reset();
            closeDepositModal();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch((error) => {
        console.error('Error during AJAX request:', error);
        alert('An error occurred: ' + error.message);
    });
}


// Delete a row
function deleteRow(button) {
    const row = button.closest('tr');
    const depositId = row.querySelector('.deposit-id').value; // Assuming each row has a data attribute for deposit ID

    console.log('id:', depositId);
    
    // Confirm deletion
    if (confirm("Are you sure you want to delete this deposit?")) {
        fetch('backend/php/delete_deposit.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ deposit_id: depositId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the row from the table
                row.remove();
                recalculateRowNumbers();
                calculateTotal();
            } else {
                console.error('Failed to delete deposit:', data.message);
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error during AJAX request:', error);
            alert('An error occurred: ' + error.message);
        });
    }
}

// Recalculate row numbers after deletion
function recalculateRowNumbers() {
    const rows = document.querySelectorAll('#table-body tr');
    rows.forEach((row, index) => {
        row.querySelector('td:first-child').textContent = `${index + 1}.`;
    });
}

// Calculate the total amount in the table
function calculateTotal() {
    let total = 0;
    const amountInputs = document.querySelectorAll('#table-body tr td:nth-child(4)');
    amountInputs.forEach(cell => {
        total += parseFloat(cell.textContent.replace('₱', '')) || 0;
    });
    document.getElementById('total-amount').textContent = total.toFixed(2);
}

// Search functionality
function searchTable() {
    const searchValue = document.getElementById('search-bar').value.toLowerCase();
    const table = document.getElementById('table-body');
    const rows = table.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        let match = false;

        for (let j = 0; j < cells.length; j++) {
            if (cells[j].innerText.toLowerCase().includes(searchValue)) {
                match = true;
                break;
            }
        }

        if (match) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}

function editRow(button) {
    const row = button.closest('tr');
    if (!row) {
        console.error("Row not found");
        return; // Exit if no row is found
    }

    const depositId = row.querySelector('.deposit-id').value; // Get deposit ID from hidden input
    const description = row.cells[1].innerText; // Assuming description is in the second cell
    const category = row.cells[2].innerText;
    const date = row.cells[3].innerText; // Assuming date is in the third cell
    const amount = parseFloat(row.cells[4].innerText.replace('₱', '').replace(',', '')); // Ensure proper parsing

    // Populate the form with these values
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_category').value = category
    document.getElementById('edit_date').value = date;
    document.getElementById('edit_amount').value = amount.toFixed(2);
    document.getElementById('deposit-id').value = depositId; // Ensure this ID exists

    openEditDepositModal(); // Show the modal to edit
}


function updateDeposit(event) {
    event.preventDefault(); // Prevent form submission

    // Collect updated form data
    const depositId = document.getElementById('deposit-id').value;
    const description = document.getElementById('edit_description').value;
    const date = document.getElementById('edit_date').value;
    const category = document.getElementById('edit_category').value;
    const amount = parseFloat(document.getElementById('edit_amount').value);
    
    console.log('Deposit ID:', depositId);
    console.log('Description:', description);
    console.log('Date:', date);
    console.log('Category:', category);
    console.log('Amount:', amount);

    // Check if any field is empty or invalid
    if (!depositId || !description || !date || !category || isNaN(amount)) {
        console.error('One or more fields are empty or invalid');
        alert('Please fill all fields correctly.');
        return; // Stop execution if validation fails
    }

    // Send updated data via fetch or AJAX to update_deposit.php
    fetch('backend/php/edit_deposit.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            deposit_id: depositId,
            description: description,
            date: date,
            category: category,
            amount: amount
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Deposit updated successfully');
            // Optionally, update the table row with the new data
            updateRowInTable(depositId, description, date, category, amount);
            closeDepositModal(); // Close the modal after updating
        } else {
            console.error('Error updating deposit:', data.message);
            alert('Error: ' + data.message);
        }
    })
    .catch((error) => {
        console.error('Error during AJAX request:', error);
        alert('An error occurred: ' + error.message);
    });
}

// Update the table row with the new deposit data
function updateRowInTable(depositId, description, date, category, amount) {
    const row = document.querySelector(`tr[data-id="${depositId}"]`);
    row.cells[1].innerText = description;
    row.cells[2].innerText = date;
    row.cells[3].innerText = `₱${amount.toFixed(2)}`;
}

