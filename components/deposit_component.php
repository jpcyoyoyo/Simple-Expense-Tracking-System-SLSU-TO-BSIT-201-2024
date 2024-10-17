
<div class="col-md-9 offset-md-3 col-12 main-app-content">

    <div class="dashboard-header container-fluid">
        <h1 class="dashboard-title">Dashboard</h1>
    </div>

    <!-- Create Deposit Record Button -->
    <button class="btn_deposit-success" id="create-deposit-btn" onclick="openDepositModal()">Create Deposit Record</button>

    <!-- Search Bar -->
    <div class="search-container">
        <input type="text" id="search-bar" class="form-control" placeholder="Search Deposits..." oninput="searchTable()" />
    </div>

    <div class="table-container">
        <h2>Deposits</h2>

        <!-- Month and Year input fields -->
        <p><strong>Month:</strong>
            <input type="month" class="month-year-input" id="month-input" value="2024-01" />
        </p>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No.</th>
                    <th>Date</th>
                    <th>Name of Transaction</th>
                    <th>Amount (₱)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <!-- Initial empty table. Rows will be added dynamically. -->
            </tbody>
        </table>

        <div class="total-section">
            <strong>Total:</strong> ₱<span id="total-amount">0.00</span>
        </div>
    </div>
</div>

<!-- Modal for Create Deposit Record -->
<div id="deposit-modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeDepositModal()">&times;</span>
        <h3>Create Deposit Record</h3>

        <form id="deposit-form" onsubmit="addDepositRecord(event)">
            <label for="description">Description</label>
            <input type="text" id="description" class="form-control" placeholder="Enter description" required />

            <label for="date">Date</label>
            <input type="date" id="date" class="form-control" required />

            <label for="category">Category</label>
            <select id="category" class="form-control" required>
                <option value="">Select Category</option>
                <option value="">Category 1</option>
                <option value="">Category 2</option>
                <!-- Add categories as options -->
            </select>

            <label for="item">Item</label>
            <input type="text" id="item" class="form-control" placeholder="Enter item" required />

            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" class="form-control" placeholder="Enter quantity" required />

            <label for="amount">Amount</label>
            <input type="number" id="amount" class="form-control" placeholder="Enter amount" step="0.01" required />

            <label for="receipt">Receipt</label>
            <input type="file" id="receipt" class="form-control" />

            <button type="submit" class="btn_deposit-primary">Add Expenses</button>
        </form>
    </div>
</div>

<script>
// Open the modal
function openDepositModal() {
    document.getElementById('deposit-modal').style.display = 'block';
}

// Close the modal
function closeDepositModal() {
    document.getElementById('deposit-modal').style.display = 'none';
}

// Add a new deposit record to the table
let rowCount = 0;
function addDepositRecord(event) {
    event.preventDefault(); // Prevent form submission

    rowCount++;
    const tableBody = document.getElementById('table-body');

    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${rowCount}.</td>
        <td>${document.getElementById('date').value}</td>
        <td>${document.getElementById('description').value}</td>
        <td>₱${parseFloat(document.getElementById('amount').value).toFixed(2)}</td>
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
}

// Delete a row
function deleteRow(button) {
    const row = button.closest('tr');
    row.remove();
    rowCount--;
    recalculateRowNumbers();
    calculateTotal();
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
</script>

</body>
</html>
