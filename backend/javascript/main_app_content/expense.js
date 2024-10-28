// Fetch and display deposits on page load
document.addEventListener('DOMContentLoaded', fetchExpenses);

function fetchExpenses() {
    fetch('backend/php/main_app_content/expense/get_expenses.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateExpenseTable(data.expenses);
            } else {
                console.error('Failed to fetch expenses:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching expenses:', error);
        });
}

// Populate the expenses table
function populateExpenseTable(expenses) {
    const tableBody = document.getElementById('expense-table-body');
    tableBody.innerHTML = ''; // Clear existing rows

    expenses.forEach((expense, index) => {
        const row = document.createElement('tr');

        // Split the item by comma and create a list
        const items = expense.item.split(',').map(item => `<li>${item.trim()}</li>`).join('');

        row.innerHTML = `
            <td>${index + 1}.</td>
            <td style="vertical-align: text-top;">${expense.date}</td>
            <td style="vertical-align: text-top;">${expense.category}</td>
            <td style="vertical-align: text-top;">${expense.description}</td>
            <td>
                <ul style="list-style-type: disc; padding-left: 20px; margin-bottom: 0;">
                    ${items}
                </ul>
            </td>
            <td style="vertical-align: text-top;">${expense.quantity}</td>
            <td style="vertical-align: text-top;">₱ ${parseFloat(expense.amount).toFixed(2)}</td>
            <input type="hidden" class="expense-id" value="${expense.id}">
            <td class="action-buttons">
                <div class="row g-2 justify-content-center" style="--bs-gutter-y: 0;">
                    <div class="col-auto">
                        <button class="btn btn-md btn-outline-primary" style="font-size: small; width: 60px; padding: 2px 0" onclick="editRow(this)">Edit</button>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-md btn-outline-danger" style="font-size: small; width: 60px; padding: 2px 0" onclick="deleteRow(this)">Delete</button>
                    </div>
                </div>

            </td>
        `;

        tableBody.appendChild(row);
    });

    calculateTotal(); // Update total after populating the table
}


// Function to open the expense modal
function openExpenseModal() {
    document.getElementById("expense-modal").style.display = "block";
}

// Function to close the expense modal
function closeExpenseModal() {
    document.getElementById("expense-modal").style.display = "none";
}

function openEditExpenseModal() {
    document.getElementById("edit-expense-modal").style.display = "block";
}

// Function to close the expense modal
function closeEditExpenseModal() {
    document.getElementById("edit-expense-modal").style.display = "none";
}

// Function to recalculate row numbers after a new record is added or deleted
function recalculateRowNumbers() {
    const rows = document.querySelectorAll("tbody tr");
    rows.forEach((row, index) => {
        row.querySelector("td:first-child").textContent = `${index + 1}.`;
    });
}

// Function to add a new expense record
let rowCount = 0;
function addExpenseRecord(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    // Collect form data
    const date = document.getElementById("create_expense_date").value;
    const category = document.getElementById("create_expense_category").value;
    const description = sanitizeInput(document.getElementById("create_expense_description").value);
    const item = sanitizeInput(document.getElementById("create_expense_item").value);
    const quantity = document.getElementById("create_expense_quantity").value;
    const amount = parseFloat(document.getElementById("create_expense_amount").value);

    // Validate that all fields are filled
    if (!description || !date || !category || !item || !quantity || !amount) {
        alert("Please fill in all required fields.");
        return;
    }

    fetch('backend/php/main_app_content/expense/create_expense.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            description: description,
            date: date,
            category: category,
            item: item,
            quantity: quantity,
            amount: amount
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // Check the server response
        if (data.success) {
            // Create a new row for the table
            const expenseId = data.expense_id; // Get the expense_id from the server response
            rowCount++;
            const tableBody = document.querySelector("tbody");
            const row = document.createElement("tr");

            // Handle multiple items by splitting them and creating <li> elements
            const items = item.split(',').map(item => `<li>${item.trim()}</li>`).join('');

            row.innerHTML = `
                <td>${rowCount}.</td>
                <td>${date}</td>
                <td>${category}</td>
                <td>${description}</td>
                <td>
                    <ul style="list-style-type: disc; padding-left: 20px; margin-bottom: 0;">
                        ${items}
                    </ul>
                </td>
                <td>${quantity}</td>
                <td>₱${parseFloat(amount).toFixed(2)}</td>
                <input type="hidden" class="expense-id" value="${expenseId}">
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
            `;

            // Append the new row to the table body
            tableBody.appendChild(row);
            calculateTotal(); // Recalculate totals

            // Recalculate the row numbers
            recalculateRowNumbers();
            updateDashboardValues();
            // Reset the form fields
            document.getElementById("create-expense-form").reset();
            // Close the modal
            closeExpenseModal();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Utility function to sanitize user input
function sanitizeInput(input) {
    // Remove leading/trailing whitespace and escape any HTML characters
    return input.trim().replace(/</g, "&lt;").replace(/>/g, "&gt;");
}


// Function to delete a record
function deleteRow(button) {
    const row = button.closest('tr');
    const expenseId = row.querySelector('.expense-id').value; // Assuming each row has a data attribute for deposit ID

    console.log('id:', expenseId);
    
    // Confirm deletion
    if (confirm("Are you sure you want to delete this deposit?")) {
        fetch('backend/php/main_app_content/expense/delete_expense.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ expense_id: expenseId })
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

// Function to edit a record (optional, but necessary if you want to allow editing)
function editRow(button) {
    const row = button.closest("tr");
    if (!row) {
        console.error("Row not found");
        return; // Exit if no row is found
    }

    const expenseId = row.querySelector('.expense-id').value; // Get expense ID from hidden input
    const date = row.cells[1].innerText; // Assuming date is in the second cell
    const category = row.cells[2].innerText;
    const description = row.cells[3].innerText; // Assuming description is in the second cell
    
    // Extracting items from <ul> and converting them back to a comma-separated string
    const itemList = row.cells[4].querySelectorAll('ul li'); // Assuming the items are inside a <ul> in the third cell
    const items = Array.from(itemList).map(li => li.textContent).join(', '); // Combine items into a comma-separated string
    
    const quantity = row.cells[5].innerText;
    const amount = parseFloat(row.cells[6].innerText.replace('₱', '').replace(',', '')); // Ensure proper parsing

    // Fill the modal with current row data
    document.getElementById("expense-id").value = expenseId; // Assuming description is actually the category
    document.getElementById("edit-expense-date").value = date;
    document.getElementById("edit-expense-category").value = category;
    document.getElementById('edit-expense-description').value = description;
    document.getElementById("edit-expense-item").value = items; // Set the joined items as value
    document.getElementById("edit-expense-quantity").value = quantity;
    document.getElementById("edit-expense-amount").value = amount;

    // Open the modal
    openEditExpenseModal();

    // Optionally, when saving changes, you can update the row with the new data
}

function updateExpense(event) {
    event.preventDefault(); // Prevent form submission
    
    const expenseId = document.getElementById("expense-id").value; // Assuming description is actually the category
    const date = document.getElementById("edit-expense-date").value;
    const category = document.getElementById("edit-expense-category").value;
    const description = sanitizeInput(document.getElementById('edit-expense-description').value);
    const item = sanitizeInput(document.getElementById("edit-expense-item").value); // Set the joined items as value
    const quantity =document.getElementById("edit-expense-quantity").value;
    const amount = parseFloat(document.getElementById("edit-expense-amount").value);

    console.log('Expense ID:', expenseId);
    console.log('Date:', date);
    console.log('Category:', category);
    console.log('Description:', description);
    console.log('Items:', item);
    console.log('Quantity:', quantity);
    console.log('Amount:', amount);

    // Check if any field is empty or invalid
    if (!expenseId) {
        alert('Deposit ID is missing.');
        return;
    }

    if (!description || !date || !category || !item || !quantity || isNaN(amount)) {
        console.error('One or more fields are empty or invalid');
        return;
    }

    fetch('backend/php/main_app_content/expense/edit_expense.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            expense_id: expenseId,
            date: date,
            category, category,
            description: description,
            item: item,
            quantity: quantity,
            amount: amount
        })
    }) 
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Expense updated successfully');
            // Update the table row with the new data
            updateRowInTable(expenseId, date, category, description, item, quantity, amount);
            calculateTotal();
            document.getElementById('update-expense-form').reset(); // Reset the form
            closeEditExpenseModal(); // Close the modal after updating
        } else {
            console.error('Error updating expense:', data.message);
            alert('Error: ' + data.message);
        }
    })
    .catch((error) => {
        console.error('Error during AJAX request:', error);
        alert('An error occurred: ' + error.message);
    });
}

function updateRowInTable(expenseId, date, category, description, item, quantity, amount) {
    const input = document.querySelector(`input.expense-id[value="${expenseId}"]`);
    
    if (!input) {
        console.error(`No row found with expenseId: ${expenseId}`);
        return;
    }

    // Get the closest row (tr) containing the hidden input
    const row = input.closest('tr');
    
    if (!row) {
        console.error('Row not found for the expense ID.');
        return;
    }

    if (row.cells.length >= 6) { // Ensure the row has at least 6 cells
        row.cells[1].innerText = date;
        row.cells[2].innerText = category;
        row.cells[3].innerText = description;

        // Split the item string by commas and convert it to a list
        const itemsList = item.split(',').map(item => `<li>${item.trim()}</li>`).join('');
        row.cells[4].innerHTML = `
            <ul style="list-style-type: disc; padding-left: 20px; margin-bottom: 0;">
                ${itemsList}
            </ul>
        `;

        row.cells[5].innerText = quantity;
        row.cells[6].innerText = `₱ ${parseFloat(amount).toFixed(2)}`;
    } else {
        console.error('Row does not have enough cells.');
    }

    updateDashboardValues();
}



// Event listener to close modal when clicked outside of it
window.onclick = function(event) {
    const modal = document.getElementById("expense-modal");
    const editModal = document.getElementById("edit-expense-modal");

    if (event.target === modal || event.target === editModal) {
        closeExpenseModal();
        closeEditExpenseModal();
    }
};

function calculateTotal() {
    const expenses = document.querySelectorAll('#expense-table-body tr');
    let total = 0;

    expenses.forEach(expense => {
        const amountText = expense.cells[6].innerText.trim(); // Get amount text from the 5th cell
        const amount = parseFloat(amountText.replace('₱', '').replace(',', '')); // Parse the amount
        if (!isNaN(amount)) {
            total += amount; // Sum the amounts
        }
    });

    console.log('Expense Total:', total);

    const expenseTotalElement = document.getElementById('expense-total-amount');
    if (expenseTotalElement) {
        expenseTotalElement.textContent = `₱ ${total.toFixed(2)}`; // Display formatted total
    } else {
        console.error('Expense total element not found.');
    }
}

function updateDashboardValues() {
    const expenses = document.querySelectorAll('#expense-table-body tr');
    let expenseTotal = 0;
    let expenseCount = 0;

    expenses.forEach(expense => {
        const amount = parseFloat(expense.cells[6].innerText.replace('₱', '').replace(',', '')); // Get amount from the 5th cell
        if (!isNaN(amount)) {
            expenseTotal += amount; // Sum the amounts
            expenseCount++; // Increment the count
        }
    });

    console.log('Expense Total:', expenseTotal);
    console.log('Expense Count:', expenseCount);

    // Fetch the current expense total from the dashboard and update the dashboard
    fetch('backend/php/main_app_content/expense/get_total_deposit.php')
    .then(response => response.json())
    .then(dashboardData => {
        if (dashboardData.success) {
            const depositTotal = parseFloat(dashboardData.deposit_total) || 0; // Ensure it's a valid number
            const balance = (depositTotal - expenseTotal).toFixed(2); // Calculate and format the balance

            console.log('Balance:', balance);

            // Update the dashboard with new values
            fetch('backend/php/main_app_content/expense/update_expense_dashboard.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    expense_total: expenseTotal.toFixed(2), // Ensure deposit total is also formatted as decimal
                    expense_count: expenseCount,
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

