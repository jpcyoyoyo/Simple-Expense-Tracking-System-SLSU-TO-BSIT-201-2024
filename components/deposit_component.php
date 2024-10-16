

<div class="col-md-9 offset-md-3 col-12 main-app-content">
<div class="table-container">
        <h2>Deposits</h2>

        <!-- Month and Year input fields -->
        <p><strong>Month:</strong> 
            <input type="month" class="month-year-input" id="month-input" value="2024-01" />
        </p>

        <div class="mb-3">
            <button class="btn btn-primary btn-add" onclick="addRow()">Add Row</button>
        </div>

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

<script>
    let rowCount = 0;

    function addRow() {
        rowCount++;
        const tableBody = document.getElementById('table-body');

        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${rowCount}.</td>
            <td><input type="date" class="form-control" /></td>
            <td><input type="text" class="form-control" placeholder="Transaction Name" /></td>
            <td><input type="number" class="form-control amount-input" placeholder="Amount" step="0.01" onchange="calculateTotal()" /></td>
            <td class="action-buttons">
                <button class="btn btn-warning btn-sm" onclick="editRow(this)"><i class="fas fa-pen"></i></button>
                <button class="btn btn-danger btn-sm" onclick="deleteRow(this)"><i class="fas fa-trash"></i></button>
            </td>
        `;

        tableBody.appendChild(row);
    }

    function deleteRow(button) {
        const row = button.closest('tr');
        row.remove();
        rowCount--;
        recalculateRowNumbers();
        calculateTotal();
    }

    function editRow(button) {
        // Logic to handle row editing if needed
    }

    function recalculateRowNumbers() {
        const rows = document.querySelectorAll('#table-body tr');
        rows.forEach((row, index) => {
            row.querySelector('td:first-child').textContent = `${index + 1}.`;
        });
    }

    function calculateTotal() {
        let total = 0;
        const amountInputs = document.querySelectorAll('.amount-input');
        amountInputs.forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById('total-amount').textContent = total.toFixed(2);
    }
</script>


