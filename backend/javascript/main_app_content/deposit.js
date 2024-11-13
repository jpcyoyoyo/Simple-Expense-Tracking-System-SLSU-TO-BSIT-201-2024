// Fetch and display deposits on page load
document.addEventListener('DOMContentLoaded', fetchDeposits);

function fetchDeposits() {
    fetch('backend/php/main_app_content/deposit/get_deposits.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateDepositTable(data.deposits);
                populateDepositFilters(data.categories, data.years);
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
    const tableBody = document.getElementById('deposit-table-body');
    tableBody.innerHTML = ''; // Clear existing rows

    if (deposits.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="6">No deposit records found.</td></tr>';
        calculateTotal();
        return;
    }

    deposits.sort((a, b) => new Date(a.date) - new Date(b.date));

    deposits.forEach((deposit, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}.</td>
            <td>${deposit.date}</td>
            <td>${deposit.category}</td>
            <td>${deposit.description}</td>
            <td>₱ ${parseFloat(deposit.amount).toFixed(2)}</td>
            <input type="hidden" class="deposit-id" value="${deposit.id}">
            <td class="action-buttons">
                <div class="row g-2 justify-content-center" style="--bs-gutter-y: 0;">
                    <div class="col-auto">
                        <button class="btn btn-md btn-outline-primary" style="font-size: small; width: 60px; padding: 2px 0;" onclick="editRow(this)">Edit</button>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-md btn-outline-danger" style="font-size: small; width: 60px; padding: 2px 0;" onclick="deleteRow(this)">Delete</button>
                    </div>
                </div>
            </td>
            <input type="hidden" class="deposit-month" value="${deposit.month}">
            <input type="hidden" class="deposit-year" value="${deposit.year}">
            <input type="hidden" class="deposit-date" value="${deposit.date}">
            <input type="hidden" class="deposit-category" value="${deposit.category}">
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

    // Collect and sanitize form data
    const description = sanitizeInput(document.getElementById('create_deposit_description').value);
    const date = document.getElementById('create_deposit_date').value;
    const category = document.getElementById('create_deposit_category').value;
    const amount = parseFloat(document.getElementById('create_deposit_amount').value);

    // Validate input
    if (!description || !date || !category || isNaN(amount) || amount <= 0) {
        alert('Please fill in all fields correctly.');
        console.error('One or more fields are empty or invalid');
        return;
    }

    // Send data to the server
    fetch('backend/php/main_app_content/deposit/create_deposit.php', {
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
            const depositId = data.deposit.deposit_id; // Get the deposit_id from the server response
            rowCount++;
            const tableBody = document.getElementById('deposit-table-body');

            console.log('Deposit ID:', depositId);

            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="row-number">${rowCount}.</td>
                <td>${date}</td>
                <td>${category}</td>
                <td>${description}</td>
                <td>₱ ${amount.toFixed(2)}</td>
                <input type="hidden" class="deposit-id" value="${depositId}">
                <td class="action-buttons">
                    <div class="row g-2 justify-content-center">
                        <div class="col-auto">
                            <button class="btn btn-md btn-outline-primary" style="font-size: small; width: 60px; padding: 2px 0;" onclick="editRow(this)">Edit</button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-md btn-outline-danger" style="font-size: small; width: 60px; padding: 2px 0;" onclick="deleteRow(this)">Delete</button>
                        </div>
                    </div>
                </td>
                <input type="hidden" class="deposit-month" value="${data.deposit.month}">
                <input type="hidden" class="deposit-year" value="${data.deposit.year}">
                <input type="hidden" class="deposit-date" value="${data.deposit.date}">
                <input type="hidden" class="deposit-category" value="${data.deposit.category}">
            `;
            tableBody.appendChild(row);

            calculateTotal(); // Update total after adding a new record
            updateDashboardValues();
            recalculateRowNumbers(); // Adjust row numbering for all rows

            // Clear the form and close the modal
            document.getElementById('create-deposit-form').reset();
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

// Function to recalculate and update the row numbers
function recalculateRowNumbers() {
    const tableBody = document.getElementById('deposit-table-body');
    const rows = tableBody.querySelectorAll('tr');
    rows.forEach((row, index) => {
        const rowNumberCell = row.querySelector('.row-number');
        if (rowNumberCell) {
            rowNumberCell.textContent = `${index + 1}.`; // Update the row number
        }
    });
}


// Utility function to sanitize user input
function sanitizeInput(input) {
    // Remove leading/trailing whitespace and escape any HTML characters
    return input.trim().replace(/</g, "&lt;").replace(/>/g, "&gt;");
}


// Delete a row
function deleteRow(button) {
    const row = button.closest('tr');
    const depositId = row.querySelector('.deposit-id').value; // Assuming each row has a data attribute for deposit ID

    console.log('id:', depositId);
    
    // Confirm deletion
    if (confirm("Are you sure you want to delete this deposit?")) {
        fetch('backend/php/main_app_content/deposit/delete_deposit.php', {
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
                updateDashboardValues();
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
    const rows = document.querySelectorAll('#deposit-table-body tr');
    rows.forEach((row, index) => {
        row.querySelector('td:first-child').textContent = `${index + 1}.`;
    });
}

// Calculate the total amount in the table
function calculateTotal() {
    const deposits = document.querySelectorAll('#deposit-table-body tr');
    let total = 0;

    deposits.forEach(deposit => {
        const amountText = deposit.cells[4].innerText.trim(); // Get amount text from the 5th cell
        const amount = parseFloat(amountText.replace('₱', '').replace(',', '')); // Parse the amount
        if (!isNaN(amount)) {
            total += amount; // Sum the amounts
        }
    });

    console.log('Deposit Total:', total);

    const depositTotalElement = document.getElementById('deposit-total-amount');
    if (depositTotalElement) {
        depositTotalElement.textContent = `₱ ${total.toFixed(2)}`; // Display formatted total
    } else {
        console.error('Deposit total element not found.');
    }
}


// Search functionality
function searchTable() {
    const searchValue = document.getElementById('search-bar').value.toLowerCase();
    const table = document.getElementById('deposit-table-body');
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
    const date = row.cells[1].innerText; // Assuming date is in the third cell
    const category = row.cells[2].innerText;
    const description = row.cells[3].innerText; // Assuming description is in the second cell
    const amount = parseFloat(row.cells[4].innerText.replace('₱', '').replace(',', '')); // Ensure proper parsing

    // Populate the form with these values
    document.getElementById('deposit-id').value = depositId; // Ensure this ID exists
    document.getElementById('edit_deposit_date').value = date;
    document.getElementById('edit_deposit_category').value = category;
    document.getElementById('edit_deposit_description').value = description;
    document.getElementById('edit_deposit_amount').value = amount.toFixed(2);

    openEditDepositModal(); // Show the modal to edit
}

function updateDeposit(event) {
    event.preventDefault(); // Prevent form submission

    // Collect updated form data
    const depositId = document.getElementById('deposit-id').value;
    const date = document.getElementById('edit_deposit_date').value; // Sanitize input
    const category = document.getElementById('edit_deposit_category').value; // Sanitize input
    const description = sanitizeInput(document.getElementById('edit_deposit_description').value); // Sanitize input
    const amount = parseFloat(document.getElementById('edit_deposit_amount').value);

    console.log('Deposit ID:', depositId);
    console.log('Description:', description);
    console.log('Date:', date);
    console.log('Category:', category);
    console.log('Amount:', amount);

    // Check if any field is empty or invalid
    if (!depositId) {
        alert('Deposit ID is missing.');
        return;
    }

    if (!description || !date || !category || isNaN(amount) || amount <= 0) { // Additional check for amount > 0
        console.error('One or more fields are empty or invalid');
        alert('Please fill in all fields correctly.');
        return;
    }

    // Send updated data via fetch or AJAX to update_deposit.php
    fetch('backend/php/main_app_content/deposit/edit_deposit.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            deposit_id: depositId,
            date: date,
            category: category,
            description: description,
            amount: amount
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Deposit updated successfully');
            // Update the table row with the new data
            updateRowInTable(depositId, data.input, data.updated_data); // Pass the entire updated data object
            calculateTotal();
            document.getElementById('update-deposit-form').reset(); // Reset the form
            closeEditDepositModal(); // Close the modal after updating
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
function updateRowInTable(depositId, inputData, updatedData) {
    // Find the row containing the hidden input with the matching depositId
    const input = document.querySelector(`input.deposit-id[value="${depositId}"]`);
    
    if (!input) {
        console.error(`No row found with depositId: ${depositId}`);
        return;
    }

    // Get the closest row (tr) containing the hidden input
    const row = input.closest('tr');
    
    if (!row) {
        console.error('Row not found for the deposit ID.');
        return;
    }

    // Update visible cells
    if (row.cells.length >= 5) { // Ensure the row has at least 5 cells
        row.cells[1].innerText = inputData.date;
        row.cells[2].innerText = inputData.category;
        row.cells[3].innerText = inputData.description;
        row.cells[4].innerText = `₱ ${inputData.amount.toFixed(2)}`;
    } else {
        console.error('Row does not have enough cells.');
    }

    // Update the hidden inputs with the updated data
    row.querySelector('.deposit-month').value = updatedData.month;
    row.querySelector('.deposit-year').value = updatedData.year;
    row.querySelector('.deposit-date').value = updatedData.date;
    row.querySelector('.deposit-category').value = updatedData.category;

    updateDashboardValues();
}


function updateDashboardValues() {
    const deposits = document.querySelectorAll('#deposit-table-body tr');
    let depositTotal = 0;
    let depositCount = 0;

    deposits.forEach(deposit => {
        const amount = parseFloat(deposit.cells[4].innerText.replace('₱', '').replace(',', '')); // Get amount from the 5th cell
        if (!isNaN(amount)) {
            depositTotal += amount; // Sum the amounts
            depositCount++; // Increment the count
        }
    });

    console.log('Deposit Total:', depositTotal);
    console.log('Deposit Count:', depositCount);

    // Fetch the current expense total from the dashboard and update the dashboard
    fetch('backend/php/main_app_content/deposit/get_total_expense.php')
    .then(response => response.json())
    .then(dashboardData => {
        if (dashboardData.success) {
            const expenseTotal = parseFloat(dashboardData.expense_total) || 0; // Ensure it's a valid number
            const balance = (depositTotal - expenseTotal).toFixed(2); // Calculate and format the balance

            console.log('Balance:', balance);

            // Update the dashboard with new values
            fetch('backend/php/main_app_content/deposit/update_deposit_dashboard.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    deposit_total: depositTotal.toFixed(2), // Ensure deposit total is also formatted as decimal
                    deposit_count: depositCount,
                    balance: balance,
                })
            })
            .then(updateResponse => updateResponse.json())
            .then(updateData => {
                if (updateData.success) {
                    console.log('Dashboard updated successfully');
                } else {
                    console.error('Failed to update dashboard:', updateData.message);
                }
            })
            .catch(error => {
                console.error('Error updating dashboard:', error);
            });
        } else {
            console.error('Failed to fetch dashboard data:', dashboardData.message);
        }
    })
    .catch(error => {
        console.error('Error fetching dashboard data:', error);
    });
}

window.onclick = function(event) {
    const modal = document.getElementById("deposit-modal");
    const editModal = document.getElementById("edit-deposit-modal");

    if (event.target === modal || event.target === editModal) {
        closeDepositModal();
        closeEditDepositModal();
    }
};

// Toggle filter options based on the selected filter type
function toggleFilterOptions(filterType, tabType) {
    const filterContainer = document.getElementById(`${tabType}-filters`);
    const allFilters = filterContainer.querySelectorAll('.filter-option');

    // Hide all filter options
    allFilters.forEach(filter => filter.style.display = 'none');

    // Display the selected filter option, or show all rows if 'All' is selected
    if (filterType === 'all') {
        applyFilter('all', tabType); // Show all rows
    } else {
        const selectedFilter = document.getElementById(`${tabType}-${filterType}-filter`);
        if (selectedFilter) selectedFilter.style.display = 'block';
    }
}

function populateDepositFilters(categories, years) {
    const categorySelect = document.getElementById('deposit-category-select');
    const monthSelect = document.getElementById('deposit-month-select');
    const yearSelect = document.getElementById('deposit-year-select');

    // Populate categories or show "No records available"
    categorySelect.innerHTML = categories.length > 0 
        ? categories.map(category => `<option value="${category}">${category}</option>`).join('')
        : `<option value="">No records available</option>`;

    // Handle months and years
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    if (years.length > 0) {
        // Populate years
        yearSelect.innerHTML = years.map(year => `<option value="${year}">${year}</option>`).join('');

        // Populate months
        monthSelect.innerHTML = months.map(month => `<option value="${month}">${month}</option>`).join('');
        monthSelect.disabled = false;  // Enable month select
    } else {
        // Show "No records available" for years and disable month dropdown
        yearSelect.innerHTML = `<option value="">No records available</option>`;
        monthSelect.disabled = true;  // Disable month select
    }
}

function applyFilter(filterType, reportType) {
    const tableBody = document.getElementById(`${reportType}-table-body`); // Get the table body by ID
    const rows = tableBody.querySelectorAll('tr'); // Get all rows in the table body
    const descriptionElement = document.getElementById(`${reportType}-description`);
    let filterMonth, filterYear, filterCategory, filterStartDate, filterEndDate;
    let descriptionText = `All ${reportType} records`; // Default description if no filters are applied
    let totalAmount = 0; // Initialize total amount for filtered rows

    // Get values based on filter type
    if (filterType === 'month') {
        filterMonth = document.getElementById(`${reportType}-month-select`).value;
        filterYear = document.getElementById(`${reportType}-year-select`).value;
        if (filterMonth && filterYear) {
            descriptionText = `Showing ${reportType} records for ${filterMonth} ${filterYear}`;
        }
    }
    if (filterType === 'category') {
        filterCategory = document.getElementById(`${reportType}-category-select`).value;
        if (filterCategory) {
            descriptionText = `Showing ${reportType} records for category: ${filterCategory}`;
        }
    }
    if (filterType === 'dateRange') {
        filterStartDate = document.getElementById(`${reportType}-start-date`).value;
        filterEndDate = document.getElementById(`${reportType}-end-date`).value;

        // Check if both start and end dates are provided
        if (!filterStartDate || !filterEndDate) {
            descriptionElement.textContent = 'Error: Please select both a start date and an end date.';
            return; // Stop filtering if either date is missing
        }

        // Parse dates
        const startDate = new Date(filterStartDate);
        const endDate = new Date(filterEndDate);

        // Check for valid dates
        if (isNaN(startDate) || isNaN(endDate)) {
            descriptionElement.textContent = 'Error: One or both of the dates are invalid.';
            return; // Stop filtering if dates are invalid
        }

        // Check for invalid date range
        if (endDate < startDate) {
            descriptionElement.textContent = 'Error: End date cannot be earlier than start date.';
            return; // Stop filtering if the date range is invalid
        }

        descriptionText = `Showing ${reportType} records from ${startDate.toLocaleDateString()} to ${endDate.toLocaleDateString()}`;
        filterStartDate = startDate;
        filterEndDate = endDate;
    }

    // Update the description element with the current filter criteria
    descriptionElement.textContent = descriptionText;

    let visibleRowIndex = 1; // Counter for visible row numbering

    rows.forEach(row => {
        const rowMonth = row.querySelector(`.${reportType}-month`)?.value;
        const rowYear = row.querySelector(`.${reportType}-year`)?.value;
        const rowCategory = row.querySelector(`.${reportType}-category`)?.value;
        const rowDate = new Date(row.querySelector(`.${reportType}-date`)?.value);

        // Select the amount cell, which is the second to last cell in the row
        const amountCell = row.querySelector(`td:nth-last-child(7)`); // Assumes the amount is the second to last cell

        let showRow = true;

        // Check if amountCell exists
        let amount = 0;
        if (amountCell) {
            amount = parseFloat(amountCell.textContent.replace(/[^0-9.-]+/g, "")); // Parse amount
        } else {
            console.warn('Amount cell not found for row:', row);
        }

        // Apply month and year filter
        if (filterMonth && filterYear) {
            if (rowMonth !== filterMonth || rowYear !== filterYear) showRow = false;
        }

        // Apply category filter
        if (filterCategory && rowCategory !== filterCategory) {
            showRow = false;
        }

        // Apply date range filter
        if (filterStartDate && filterEndDate) {
            if (rowDate < filterStartDate || rowDate > filterEndDate) {
                showRow = false;
            }
        }

        // Show or hide the row based on filter criteria
        if (showRow) {
            row.style.display = ''; // Show the row
            row.querySelector('td:first-child').textContent = visibleRowIndex++; // Update row number
            totalAmount += amount; // Only add to total if the row is visible
        } else {
            row.style.display = 'none'; // Hide the row
        }
    });

    // Update the total amount display for the respective report type
    document.getElementById(`${reportType}-total-amount`).textContent = `₱ ${totalAmount.toFixed(2)}`;
}
