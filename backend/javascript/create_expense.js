// Function to open the expense modal
function openExpenseModal() {
    const modal = document.getElementById("expense-modal");
    modal.style.display = "block";
}

// Function to close the expense modal
function closeExpenseModal() {
    const modal = document.getElementById("expense-modal");
    modal.style.display = "none";
}

// Function to recalculate row numbers after a new record is added or deleted
function recalculateRowNumbers() {
    const rows = document.querySelectorAll("tbody tr");
    rows.forEach((row, index) => {
        row.querySelector("td:first-child").textContent = `${index + 1}.`;
    });
}

// Function to add a new expense record
function addExpenseRecord(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    // Collect form data
    const description = document.getElementById("description").value;
    const date = document.getElementById("date").value;
    const category = document.getElementById("category").value;
    const item = document.getElementById("item").value;
    const quantity = document.getElementById("quantity").value;
    const amount = document.getElementById("amount").value;

    // Validate that all fields are filled
    if (!description || !date || !category || !item || !quantity || !amount) {
        alert("Please fill in all required fields.");
        return;
    }

    // Create a new row for the table
    const tableBody = document.querySelector("tbody");
    const newRow = document.createElement("tr");

    newRow.innerHTML = `
        <td></td> <!-- Row number will be recalculated -->
        <td>${date}</td>
        <td>${category}</td>
        <td>${item}</td>
        <td>${quantity}</td>
        <td>$${parseFloat(amount).toFixed(2)}</td>
        <td>
            <button class="btn btn-sm btn-outline-primary" onclick="editRecord(this)">✏️ Edit</button>
            <button class="btn btn-sm btn-outline-danger" onclick="deleteRecord(this)">🗑️ Delete</button>
        </td>
    `;

    // Append the new row to the table body
    tableBody.appendChild(newRow);

    // Recalculate the row numbers
    recalculateRowNumbers();

    // Close the modal
    closeExpenseModal();

    // Reset the form fields
    document.getElementById("deposit-form").reset();
}

// Function to delete a record
function deleteRecord(button) {
    const row = button.closest("tr");
    row.remove();
    recalculateRowNumbers();
}

// Function to edit a record (optional, but necessary if you want to allow editing)
function editRecord(button) {
    const row = button.closest("tr");

    // Fill the modal with current row data
    document.getElementById("description").value = row.cells[3].textContent;
    document.getElementById("date").value = row.cells[1].textContent;
    document.getElementById("category").value = row.cells[2].textContent;
    document.getElementById("item").value = row.cells[3].textContent;
    document.getElementById("quantity").value = row.cells[4].textContent;
    document.getElementById("amount").value = row.cells[5].textContent.replace('$', '');

    // Open the modal
    openExpenseModal();

    // Optionally, when saving changes, you can update the row with the new data
}

// Event listener to close modal when clicked outside of it
window.onclick = function(event) {
    const modal = document.getElementById("deposit-modal");
    if (event.target === modal) {
        closeExpenseModal();
    }
};
