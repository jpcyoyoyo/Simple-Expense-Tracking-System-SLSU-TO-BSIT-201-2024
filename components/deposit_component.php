<?php
// database connection parameters
$servername = "localhost"; // Your database server
$username = "root";        // Your database username
$password = "";            // Your database password
$dbname = "expense_tracker"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery for AJAX -->
</head>
<body>

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
                <option value="Category 1">Category 1</option>
                <option value="Category 2">Category 2</option>
                <!-- Add more categories as needed -->
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

    const userId = 1; // Replace this with the actual user ID from the session
    const description = document.getElementById('description').value;
    const date = document.getElementById('date').value;
    const category = document.getElementById('category').value;
    const item = document.getElementById('item').value;
    const quantity = document.getElementById('quantity').value;
    const amount = document.getElementById('amount').value;
    const receipt = document.getElementById('receipt').files[0];

    // Create a FormData object to send the data
    const formData = new FormData();
    formData.append('user_id', userId);
    formData.append('description', description);
    formData.append('date', date);
    formData.append('category', category);
    formData.append('item', item);
    formData.append('quantity', quantity);
    formData.append('amount', amount);
    if (receipt) {
        formData.append('receipt', receipt);
    }

    // Make AJAX request to add_deposit.php
    fetch('add_deposit.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the table with new deposit
            rowCount++;
            const tableBody = document.getElementById('table-body');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${rowCount}.</td>
                <td>${date}</td>
                <td>${description}</td>
                <td>₱${parseFloat(amount).toFixed(2)}</td>
                <td class="action-buttons">
                    <button class="btn btn-warning btn-sm" onclick="editRow(this)">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
            calculateTotal(); // Update total

            // Clear the form and close the modal
            document.getElementById('deposit-form').reset();
            closeDepositModal();
        } else {
            alert(data.message); // Show error message
        }
    })
    .catch(error => console.error('Error:', error));
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

<!-- Add the PHP script here -->
<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $user_id = $_POST['user_id']; // You might want to get this from the session
    $description = $_POST['description'];
    $date = $_POST['date'];
    $category = $_POST['category'];
    $item = $_POST['item'];
    $quantity = $_POST['quantity'];
    $amount = $_POST['amount'];

    // Handle receipt image upload
    $receipt_image = '';
    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["receipt"]["name"]);
        if (move_uploaded_file($_FILES["receipt"]["tmp_name"], $target_file)) {
            $receipt_image = $target_file;
        }
    }

    // Prepare SQL statement
    $sql = "INSERT INTO deposits (user_id, description, date, category, item, quantity, amount, receipt_image)
            VALUES ('$user_id', '$description', '$date', '$category', '$item', '$quantity', '$amount', '$receipt_image')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Return a success response
        echo json_encode(['success' => true, 'message' => 'Deposit added successfully']);
    } else {
        // Return an error response
        echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }

    // Close the connection
    $conn->close();
}
?>

</body>
</html>
