// Fetch and display deposits on page load
document.addEventListener('DOMContentLoaded', fetchCategories);

function fetchCategories() {
    fetch('backend/php/main_app_content/category/get_categories.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateCategoryTable(data.categories);
                populateCategoryFilters(data.years);
            } else {
                console.error('Failed to fetch categories:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching categories:', error);
        });
}

// Populate the deposits table
function populateCategoryTable(categories) {
    const tableBody = document.getElementById('category-table-body');
    let noRecordsRow = document.getElementById('no-records-row'); // Get the "No records found" row
    tableBody.innerHTML = ''; // Clear existing rows

    // Create the "No records found" row if it doesn't exist
    if (!noRecordsRow) {
        noRecordsRow = document.createElement('tr');
        noRecordsRow.id = 'no-records-row'; // Add an ID for easy access
        noRecordsRow.style.display = 'none'; // Hide it by default
        noRecordsRow.innerHTML = '<td colspan="5">No categories found.</td>';
        tableBody.appendChild(noRecordsRow);
    }

    // If no deposits, show the "No records found" row
    if (categories.length === 0) {
        noRecordsRow.style.display = ''; // Show "No records found"
        calculateTotal();
        return;
    }

    // Hide "No records found" row when there are deposits
    noRecordsRow.style.display = 'none';

    // Sort the deposits by date
    categories.sort((a, b) => new Date(a.date) - new Date(b.date));

    categories.forEach((category, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}.</td>
            <td>${category.created_at}</td>
            <td>${category.name}</td>
            <td>${category.description}</td>
            <input type="hidden" class="category-id" value="${category.id}">
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
            <input type="hidden" class="category-month" value="${category.month}">
            <input type="hidden" class="category-year" value="${category.year}">
            <input type="hidden" class="category-date" value="${category.created_at}">
        `;
        tableBody.appendChild(row);
    });

    calculateTotal(); // Update total after populating the table
}



// Open the modal
function openCategoryModal() {
    document.getElementById('category-modal').style.display = 'block';
}

function openEditCategoryModal() {
    document.getElementById('edit-category-modal').style.display = 'block';
}

// Close the modal
function closeCategoryModal() {
    document.getElementById('category-modal').style.display = 'none';
}

function closeEditCategoryModal() {
    document.getElementById('edit-category-modal').style.display = 'none';
}

// Add a new deposit record to the table
let rowCount = 0;

function addCategoryRecord(event) {
    event.preventDefault(); // Prevent form submission

    // Collect and sanitize form data
    const name = sanitizeInput(document.getElementById('create_category_name').value);
    const description = sanitizeInput(document.getElementById('create_category_description').value);

    // Validate input
    if (!name || !description) {
        alert('Please fill in all fields correctly.');
        console.error('One or more fields are empty or invalid');
        return;
    }

    // Send data to the server
    fetch('backend/php/main_app_content/category/create_category.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name: name,
            description: description
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // Check the server response
        if (data.success) {
            const categoryId = data.category.category_id;
            const createdAt = data.category.created_at; // Get the category_id from the server response
            rowCount++;
            const tableBody = document.getElementById('category-table-body');

            console.log('Category ID:', categoryId);

            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="row-number">${rowCount}.</td>
                <td>${createdAt}</td>
                <td>${name}</td>
                <td>${description}</td>
                <input type="hidden" class="category-id" value="${categoryId}">
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
                <input type="hidden" class="category-month" value="${data.category.month}">
                <input type="hidden" class="category-year" value="${data.category.year}">
                <input type="hidden" class="category-date" value="${data.category.created_at}">
            `;
            tableBody.appendChild(row);

            calculateTotal(); // Update total after adding a new record
            recalculateRowNumbers(); // Adjust row numbering for all rows
            checkTotalRecord();

            // Clear the form and close the modal
            document.getElementById('create-category-form').reset();
            closeCategoryModal();
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
    const tableBody = document.getElementById('category-table-body');
    const rows = tableBody.querySelectorAll('tr');
    rows.forEach((row, index) => {
        if (row.id === 'no-records-row') {
            return;
        }

        row.querySelector('td:first-child').textContent = `${index}.`;
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
    const categoryId = row.querySelector('.category-id').value; // Assuming each row has a data attribute for deposit ID

    console.log('id:', categoryId);
    
    // Confirm deletion
    if (confirm("Are you sure to delete this category permanently? The action will remove also the deposit and expense records under this category")) {
        fetch('backend/php/main_app_content/category/delete_category.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ category_id: categoryId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the row from the table
                row.remove();
                recalculateRowNumbers();
                calculateTotal();
                checkTotalRecord();
            } else {
                console.error('Failed to delete category:', data.message);
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error during AJAX request:', error);
            alert('An error occurred: ' + error.message);
        });
    }
}

// Calculate the total amount in the table
function calculateTotal() {
    const totalAmount = document.getElementById('category-total-amount');
    const rows = document.querySelectorAll('#category-table-body tr');
    totalAmount.textContent = rows.length - 1;
}


// Search functionality
function searchTable() {
    const searchValue = document.getElementById('search-bar').value.toLowerCase();
    const table = document.getElementById('category-table-body');
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

    const categoryId = row.querySelector('.category-id').value; // Get category ID from hidden input
    const name = row.cells[2].innerText;
    const oldName = row.cells[2].innerText;
    const description = row.cells[3].innerText; // Assuming description is in the second cell

    console.log('Category ID:', categoryId);

    // Populate the form with these values
    document.getElementById('category-id').value = categoryId; // Ensure this ID exists
    document.getElementById('old-category-name').value = oldName; // Ensure this ID exists
    document.getElementById('edit_category_description').value = description;
    document.getElementById('edit_category_name').value = name;

    openEditCategoryModal(); // Show the modal to edit
}

function updateCategory(event) {
    event.preventDefault(); // Prevent form submission

    // Collect updated form data
    const categoryId = document.getElementById('category-id').value;
    const oldName = document.getElementById('old-category-name').value;
    const name = sanitizeInput(document.getElementById('edit_category_name').value); // Sanitize input
    const description = sanitizeInput(document.getElementById('edit_category_description').value); // Sanitize input

    console.log('Category ID:', categoryId);
    console.log('Description:', description);
    console.log('Name:', name);

    // Check if any field is empty or invalid
    if (!categoryId) {
        alert('Category ID is missing.');
        return;
    }

    if (!description || !name) { // Additional check for amount > 0
        console.error('One or more fields are empty or invalid');
        alert('Please fill in all fields correctly.');
        return;
    }

    // Send updated data via fetch or AJAX to update_category.php
    fetch('backend/php/main_app_content/category/edit_category.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            category_id: categoryId,
            old_name: oldName,
            name: name,
            description: description
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Category updated successfully');
            // Update the table row with the new data
            updateRowInTable(categoryId, data.input, data.updated_data); // Pass the entire updated data object
            calculateTotal();
            document.getElementById('update-category-form').reset(); // Reset the form
            closeEditCategoryModal(); // Close the modal after updating
        } else {
            console.error('Error updating category:', data.message);
            alert('Error: ' + data.message);
        }
    })
    .catch((error) => {
        console.error('Error during AJAX request:', error);
        alert('An error occurred: ' + error.message);
    });
}


// Update the table row with the new deposit data
function updateRowInTable(categoryId, inputData, updatedData) {
    // Find the row containing the hidden input with the matching depositId
    const input = document.querySelector(`input.category-id[value="${categoryId}"]`);
    
    if (!input) {
        console.error(`No row found with categoryId: ${categoryId}`);
        return;
    }

    // Get the closest row (tr) containing the hidden input
    const row = input.closest('tr');
    
    if (!row) {
        console.error('Row not found for the category ID.');
        return;
    }

    // Update visible cells
    if (row.cells.length >= 2) { // Ensure the row has at least 5 cells
        row.cells[2].innerText = inputData.name;
        row.cells[3].innerText = inputData.description;
    } else {
        console.error('Row does not have enough cells.');
    }

    // Update the hidden inputs with the updated data
    row.querySelector('.category-month').value = updatedData.month;
    row.querySelector('.category-year').value = updatedData.year;
    row.querySelector('.category-date').value = updatedData.created_at;
}

window.onclick = function(event) {
    const modal = document.getElementById("category-modal");
    const editModal = document.getElementById("edit-category-modal");

    if (event.target === modal || event.target === editModal) {
        closeCategoryModal();
        closeEditCategoryModal();
    }
}

function checkTotalRecord() {
    const rows = document.querySelectorAll('#expense-table-body tr'); // Select all rows in the tbody
    const noRecordsRow = document.getElementById('no-records-row'); // Get the "No records found" row
    
    // Check if there are any visible rows in the tbody
    if (rows.length - 1 === 0) {
        noRecordsRow.style.display = ''; // Show "No records found"
    } else {
        noRecordsRow.style.display = 'none'; // Hide "No records found"
    }

    console.log('Row length: ', rows.length);
}

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

function populateCategoryFilters(years) {
    const monthSelect = document.getElementById('category-month-select');
    const yearSelect = document.getElementById('category-year-select');

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
    const tableBody = document.getElementById(`${reportType}-table-body`);
    const rows = tableBody.querySelectorAll('tr');
    const descriptionElement = document.getElementById(`${reportType}-description`);
    const noRecordsRow = document.getElementById('no-records-row'); // Get the "No records found" row
    let filterMonth, filterYear, filterCategory, filterStartDate, filterEndDate;
    let descriptionText = `All ${reportType} records`;
    let hasVisibleRows = false; // Track if any row is visible after filtering

    if (filterType === 'month') {
        filterMonth = document.getElementById(`${reportType}-month-select`).value;
        filterYear = document.getElementById(`${reportType}-year-select`).value;
        if (filterMonth && filterYear) {
            descriptionText = `Showing ${reportType} records for ${filterMonth} ${filterYear}`;
        }
    }
    if (filterType === 'dateRange') {
        filterStartDate = document.getElementById(`${reportType}-start-date`).value;
        filterEndDate = document.getElementById(`${reportType}-end-date`).value;

        if (!filterStartDate || !filterEndDate) {
            descriptionElement.textContent = 'Error: Please select both a start date and an end date.';
            return;
        }

        const startDate = new Date(filterStartDate);
        const endDate = new Date(filterEndDate);

        if (isNaN(startDate) || isNaN(endDate)) {
            descriptionElement.textContent = 'Error: One or both of the dates are invalid.';
            return;
        }

        if (endDate < startDate) {
            descriptionElement.textContent = 'Error: End date cannot be earlier than start date.';
            return;
        }

        descriptionText = `Showing ${reportType} records from ${startDate.toLocaleDateString()} to ${endDate.toLocaleDateString()}`;
        filterStartDate = startDate;
        filterEndDate = endDate;
    }

    descriptionElement.textContent = descriptionText;

    let visibleRowIndex = 1; // Start renumbering from 1

    rows.forEach(row => {
        // Skip the "No records found" row
        if (row.id === 'no-records-row') {
            return; // Skip this row entirely
        }

        const rowMonth = row.querySelector(`.${reportType}-month`)?.value;
        const rowYear = row.querySelector(`.${reportType}-year`)?.value;
        const rowDate = new Date(row.querySelector(`.${reportType}-date`)?.value);

        let showRow = true;
        if (filterMonth && filterYear && (rowMonth !== filterMonth || rowYear !== filterYear)) showRow = false;
        if (filterStartDate && filterEndDate && (rowDate < filterStartDate || rowDate > filterEndDate)) showRow = false;

        if (showRow) {
            row.style.display = '';
            row.querySelector('td:first-child').textContent = visibleRowIndex++; // Update index for visible rows
            totalAmount += amount;
            hasVisibleRows = true;
        } else {
            row.style.display = 'none';
        }
    });

    // Show the "No records found" row if no rows are visible
    if (!hasVisibleRows && noRecordsRow) {
        noRecordsRow.style.display = ''; // Show the "No records found" row
    } else if (noRecordsRow) {
        noRecordsRow.style.display = 'none'; // Hide it if there are visible rows
    }

}
