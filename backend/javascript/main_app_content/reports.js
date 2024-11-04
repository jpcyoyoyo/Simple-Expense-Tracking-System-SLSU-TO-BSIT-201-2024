document.addEventListener('DOMContentLoaded', () => {
    fetchDepositsReports();
    fetchExpensesReports();
});

function fetchDepositsReports() {
    fetch('backend/php/main_app_content/reports/get_deposit_reports.php')
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

// Fetch expenses and populate table and filters
function fetchExpensesReports() {
    fetch('backend/php/main_app_content/reports/get_expense_reports.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateExpenseTable(data.expenses);
                populateExpenseFilters(data.categories, data.years);
            } else {
                console.error('Failed to fetch expenses:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching expenses:', error);
        });
}

// Populate deposit filters dynamically
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

// Populate expense filters dynamically
function populateExpenseFilters(categories, years) {
    const categorySelect = document.getElementById('expense-category-select');
    const monthSelect = document.getElementById('expense-month-select');
    const yearSelect = document.getElementById('expense-year-select');

    // Populate categories or show "No records available"
    categorySelect.innerHTML = categories.length > 0 
        ? categories.map(category => `<option value="${category}">${category}</option>`).join('')
        : `<option value="">No records available</option>`;

    // Handle months and years
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    if (years.length > 0) {
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
    const descriptionElement = document.getElementById(`${reportType}-report-description`);
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
        const amountCell = row.querySelector(`td:nth-last-child(5)`); // Assumes the amount is the second to last cell

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


const userFullName = "<?php echo $_SESSION['fullname']; ?>"; // Assuming 'fullname' is stored in the session

async function generateReportDocument(type) {
    const titleElement = document.querySelector(`.${type}-report-title h2`);
    const descriptionElement = document.querySelector(`.${type}-report-title p`);
    const tableContainer = document.querySelector(`.report-table-container.${type}-table`);
    
    // Ensure elements are found before proceeding
    if (!titleElement || !descriptionElement || !tableContainer) {
        console.error('One or more report elements could not be found.');
        return;
    }

    // Select the total amount section content
    const amountElement = document.querySelector(`.total-section span`).textContent || '0.00';

    // Combine description with user's full name
    const fullnameText = `Generated by: ${userFullName}`;

    // Save original color and apply black color to each table cell
    const cells = tableContainer.querySelectorAll('th, td');

    // Create a container for the PDF content with enforced black text
    const pdfContent = `
        <div style="font-family: Archivo; margin: 20px; color: black;">
            <h1 style="text-align: center; color: black;">${titleElement.textContent}</h2>
            <p style="text-align: center; color: black; margin: 0;">${descriptionElement.textContent}</p>
            <p style="text-align: center; color: black; margin: 0;">${fullnameText}</p>
            <div style="color: #000;">${tableContainer.outerHTML}</div>
            <div style="margin: 10px 30px; text-align: right; color: black;">
                <p style="font-size: 1.5em;">Total: <span>${amountElement}</span></p>
            </div>
        </div>
    `;

    // Temporary element to hold content for conversion
    const tempDiv = document.createElement('div');
    tempDiv.style.position = 'absolute';
    tempDiv.style.top = '-9999px';
    tempDiv.innerHTML = pdfContent;
    document.body.appendChild(tempDiv);

    // Use html2canvas to capture the content and convert it to PDF
    const { jsPDF } = window.jspdf;
    const pdfDoc = new jsPDF('p', 'pt', 'a4');
    
    await html2canvas(tempDiv, { scale: 3 }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const imgWidth = pdfDoc.internal.pageSize.getWidth();
        const imgHeight = (canvas.height * imgWidth) / canvas.width;
        pdfDoc.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
    });

    document.body.removeChild(tempDiv); // Clean up temporary element

    // Save the PDF with the report title as the file name
    pdfDoc.save(`${titleElement.textContent}.pdf`);
}


// Populate the deposits table
// Populate the deposits table and calculate total amount
function populateDepositTable(deposits) {
    const tableBody = document.getElementById('deposit-table-body');
    tableBody.innerHTML = '';

    if (deposits.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="5">No deposit records found.</td></tr>';
        document.getElementById('deposit-total-amount').textContent = '₱ 0.00'; // Reset total amount
        return;
    }

    // Sort deposits by date (ascending)
    deposits.sort((a, b) => new Date(a.date) - new Date(b.date));
    
    let totalAmount = 0; // Initialize total amount

    deposits.forEach((deposit, index) => {
        const row = document.createElement('tr');
        const amount = parseFloat(deposit.amount); // Parse the amount
        totalAmount += amount; // Add to total amount

        row.innerHTML = `
            <td>${index + 1}.</td>
            <td>${deposit.date}</td>
            <td>${deposit.category}</td>
            <td>${deposit.description}</td>
            <td>₱ ${amount.toFixed(2)}</td>
            <input type="hidden" class="deposit-month" value="${deposit.month}">
            <input type="hidden" class="deposit-year" value="${deposit.year}">
            <input type="hidden" class="deposit-date" value="${deposit.date}">
            <input type="hidden" class="deposit-category" value="${deposit.category}">
        `;
        tableBody.appendChild(row);
    });

    // Update the total amount display
    document.getElementById('deposit-total-amount').textContent = `₱ ${totalAmount.toFixed(2)}`;
}

// Populate the expenses table and calculate total amount
function populateExpenseTable(expenses) {
    const tableBody = document.getElementById('expense-table-body');
    tableBody.innerHTML = '';

    if (expenses.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="7">No expense records found.</td></tr>';
        document.getElementById('expense-total-amount').textContent = '₱ 0.00'; // Reset total amount
        return;
    }

    // Sort expenses by date (ascending)
    expenses.sort((a, b) => new Date(a.date) - new Date(b.date));
    
    let totalAmount = 0; // Initialize total amount

    expenses.forEach((expense, index) => {
        const items = expense.item.split(',').map(item => `<li>${item.trim()}</li>`).join('');
        const amount = parseFloat(expense.amount); // Parse the amount
        totalAmount += amount; // Add to total amount

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}.</td>
            <td>${expense.date}</td>
            <td>${expense.category}</td>
            <td>${expense.description}</td>
            <td><ul>${items}</ul></td>
            <td>${expense.quantity}</td>
            <td>₱ ${amount.toFixed(2)}</td>
            <input type="hidden" class="expense-month" value="${expense.month}">
            <input type="hidden" class="expense-year" value="${expense.year}">
            <input type="hidden" class="expense-date" value="${expense.date}">
            <input type="hidden" class="expense-category" value="${expense.category}">
        `;
        tableBody.appendChild(row);
    });

    // Update the total amount display
    document.getElementById('expense-total-amount').textContent = `₱ ${totalAmount.toFixed(2)}`;
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
