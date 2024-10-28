<div class="app_header d-flex flex-row justify-content-between align-items-center">
    <h1>Generate Reports</h1>
</div>

<div class="app_body container">
    <div class="report-container">
        <!-- Tab Navigation with Full-Width Tabs -->
        <ul class="nav nav-tabs d-flex" id="reportTabs" role="tablist">
            <li class="tab-nav-item flex-fill" role="presentation">
                <button class="tab-nav-link active w-100" id="deposit-tab" data-bs-toggle="tab" data-bs-target="#deposit" type="button" role="tab" aria-controls="deposit" aria-selected="true">Deposit</button>
            </li>
            <li class="tab-nav-item flex-fill" role="presentation">
                <button class="tab-nav-link w-100" id="expense-tab" data-bs-toggle="tab" data-bs-target="#expense" type="button" role="tab" aria-controls="expense" aria-selected="false">Expense</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="reportTabsContent">
            <!-- Deposit Tab Pane -->
            <div class="tab-pane fade show active" id="deposit" role="tabpanel" aria-labelledby="deposit-tab">
                
                <div class="tab-pane-head container">
                    <!-- Filter Buttons -->
                    <div class="row d-flex justify-content-center align-items-center mb-2">
                        <div class="filter-buttons d-flex justify-content-center align-items-center">
                            <h4 style="margin: 0; margin-right: 10px;">Filters: </h4>
                            <button class="filter-btn btn-outline-primary" onclick="toggleFilterOptions('all', 'deposit')">All</button>
                            <button class="filter-btn btn-outline-primary" onclick="toggleFilterOptions('month', 'deposit')">Month</button>
                            <button class="filter-btn btn-outline-primary" onclick="toggleFilterOptions('category', 'deposit')">Category</button>
                            <button class="filter-btn btn-outline-primary" onclick="toggleFilterOptions('dateRange', 'deposit')">Date Range</button>
                        </div>
                    </div>
                    
                    <div class="row d-flex justify-content-center align-items-center mb-2">
                        <!-- Filter Options (hidden by default) -->
                        <div id="deposit-filters" class="filter-options d-flex justify-content-center">
                            <!-- Month Filter -->
                            <div id="deposit-month-filter" class="filter-option" style="display: block;">
                                <label for="deposit-month-select">Select Month:</label>
                                <select id="deposit-month-select">
                                    <!-- Add more months as needed -->
                                </select>

                                <label for="deposit-year-select">Select Year:</label>
                                <select id="deposit-year-select">
                                    <!-- Add more months as needed -->
                                </select>

                                <button class="filter-btn btn-outline-primary" onclick="applyFilter('month', 'deposit')">Apply</button>
                            </div>

                            <!-- Category Filter -->
                            <div id="deposit-category-filter" class="filter-option" style="display: none;">
                                <label for="deposit-category-select">Select Category:</label>
                                <select id="deposit-category-select">
                                    <!-- Add more categories as needed -->
                                </select>
                                <button class="filter-btn btn-outline-primary" onclick="applyFilter('category', 'deposit')">Apply</button>
                            </div>

                            <!-- Date Range Filter -->
                            <div id="deposit-dateRange-filter" class="filter-option" style="display: none;">
                                
                                <label for="deposit-start-date">Start Date:</label>
                                <input type="date" id="deposit-start-date">
                            
                                <label for="deposit-end-date">End Date:</label>
                                <input type="date" id="deposit-end-date">
                                                
                                <button class="filter-btn btn-outline-primary" onclick="applyFilter('dateRange', 'deposit')">Apply</button>
                                
                            </div>
                        </div>
                    </div>
                
                    <div class="report-title">
                        <h2>Deposit Report</h2>
                        <p>Content for deposits goes here.</p>
                    </div>
                </div>

                <div class="report-table-container">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO.</th>
                                        <th style="padding-right: 60px">DATE</th>
                                        <th style="padding-right: 60px">CATEGORY</th>
                                        <th style="padding-right: 60px">NAME OF TRANSACTION</th>
                                        <th style="padding-right: 60px">AMOUNT (₱)</th>
                                    </tr>
                                </thead>
                                <tbody id="deposit-table-body">
                                    <!-- Initial empty table. Rows will be added dynamically. -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Expense Tab Pane -->
            <div class="tab-pane fade" id="expense" role="tabpanel" aria-labelledby="expense-tab">
                <div class="tab-pane-head container">
                    <!-- Filter Buttons -->
                    <div class="row d-flex justify-content-center align-items-center mb-2">
                        <div class="filter-buttons d-flex justify-content-center align-items-center">
                            <h4 style="margin: 0; margin-right: 10px;">Filters: </h4>
                            <button class="filter-btn btn-outline-primary" onclick="toggleFilterOptions('all', 'expense')">All</button>
                            <button class="filter-btn btn-outline-primary" onclick="toggleFilterOptions('month', 'expense')">Month</button>
                            <button class="filter-btn btn-outline-primary" onclick="toggleFilterOptions('category', 'expense')">Category</button>
                            <button class="filter-btn btn-outline-primary" onclick="toggleFilterOptions('dateRange', 'expense')">Date Range</button>
                        </div>
                    </div>
                    
                    <div class="row d-flex justify-content-center align-items-center mb-2">
                        <!-- Filter Options (hidden by default) -->
                        <div id="expense-filters" class="filter-options d-flex justify-content-center">
                            <!-- Month Filter -->
                            <div id="expense-month-filter" class="filter-option" style="display: block;">
                                <label for="expense-month-select">Select Month:</label>
                                <select id="expense-month-select">
                                    <!-- Add more months as needed -->
                                </select>

                                <label for="expense-year-select">Select Year:</label>
                                <select id="expense-year-select">
                                    <!-- Add more months as needed -->
                                </select>
                                <button class="filter-btn btn-outline-primary" onclick="applyFilter('month', 'deposit')">Apply</button>
                            </div>

                            <!-- Category Filter -->
                            <div id="expense-category-filter" class="filter-option" style="display: none;">
                                <label for="expense-category-select">Select Category:</label>
                                <select id="expense-category-select">
                                    <!-- Add more categories as needed -->
                                </select>
                                <button class="filter-btn btn-outline-primary" onclick="applyFilter('category', 'deposit')">Apply</button>
                            </div>

                            <!-- Date Range Filter -->
                            <div id="expense-dateRange-filter" class="filter-option" style="display: none;">
                                
                                <label for="expense-start-date">Start Date:</label>
                                <input type="date" id="expense-start-date">
                            
                                <label for="expense-end-date">End Date:</label>
                                <input type="date" id="expense-end-date">
                                                
                                <button class="filter-btn btn-outline-primary" onclick="applyFilter('dateRange', 'deposit')">Apply</button>
                                
                            </div>
                        </div>
                    </div>
                
                    <div class="report-title">
                        <h2>Expense Report</h2>
                        <p>Content for xpenses goes here.</p>
                    </div>
                </div>

                <div class="report-table-container">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO.</th>
                                        <th style="padding-right: 60px">DATE</th>
                                        <th style="padding-right: 60px">CATEGORY</th>
                                        <th style="padding-right: 60px">DESCRIPTION</th>
                                        <th style="padding-right: 60px">ITEMS</th>
                                        <th>QTY</th>
                                        <th style="padding-right: 60px">AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody id="expense-table-body">
                                    <!-- Additional rows can go here -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            
            </div>
        </div>
    </div>
</div>

<script>

document.addEventListener('DOMContentLoaded', fetchDepositsReports);
document.addEventListener('DOMContentLoaded', fetchExpensesReports);

function fetchDepositsReports() {
    fetch('backend/php/main_app_content/reports/get_deposit_reports.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateDepositTable(data.deposits);
                populateDepositFilters(data.categories, data.months, data.years);
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
                populateExpenseFilters(data.categories, data.months, data.years);
            } else {
                console.error('Failed to fetch expenses:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching expenses:', error);
        });
}

// Populate deposit filters dynamically
function populateDepositFilters(categories, months, years) {
    const categorySelect = document.getElementById('deposit-category-select');
    const monthSelect = document.getElementById('deposit-month-select');

    // Populate categories
    categorySelect.innerHTML = categories.map(category => `<option value="${category}">${category}</option>`).join('');

    // Populate months
    monthSelect.innerHTML = months.map(month => `<option value="${month}">${month}</option>`).join('');

    // Populate years (e.g., if you add a separate year select)
    const yearSelect = document.createElement('select');
    yearSelect.id = 'deposit-year-select';
    yearSelect.innerHTML = years.map(year => `<option value="${year}">${year}</option>`).join('');
    document.querySelector('#deposit-filters').appendChild(yearSelect);
}

// Populate expense filters dynamically
function populateExpenseFilters(categories, months, years) {
    const categorySelect = document.getElementById('expense-category-select');
    const monthSelect = document.getElementById('expense-month-select');

    // Populate categories
    categorySelect.innerHTML = categories.map(category => `<option value="${category}">${category}</option>`).join('');

    // Populate months
    monthSelect.innerHTML = months.map(month => `<option value="${month}">${month}</option>`).join('');

    // Populate years (optional, if you add a year select)
    const yearSelect = document.createElement('select');
    yearSelect.id = 'expense-year-select';
    yearSelect.innerHTML = years.map(year => `<option value="${year}">${year}</option>`).join('');
    document.querySelector('#expense-filters').appendChild(yearSelect);
}

// Apply filter function
function applyFilter(filterType, reportType) {
    let filterValue = {};

    if (filterType === 'month') {
        filterValue.month = document.getElementById(`${reportType}-month-select`).value;
    } else if (filterType === 'category') {
        filterValue.category = document.getElementById(`${reportType}-category-select`).value;
    } else if (filterType === 'dateRange') {
        filterValue.startDate = document.getElementById(`${reportType}-start-date`).value;
        filterValue.endDate = document.getElementById(`${reportType}-end-date`).value;
    }

    // Filter records based on criteria
    fetchFilteredRecords(reportType, filterValue);
}

// Fetch records based on filter criteria
function fetchFilteredRecords(reportType, filterValue) {
    const url = `backend/php/main_app_content/${reportType}/get_${reportType}.php`;

    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(filterValue)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (reportType === 'deposit') {
                    populateDepositTable(data.deposits);
                } else {
                    populateExpenseTable(data.expenses);
                }
            } else {
                console.error(`Failed to fetch filtered ${reportType} records:`, data.message);
            }
        })
        .catch(error => {
            console.error(`Error fetching filtered ${reportType} records:`, error);
        });
}

// Populate the deposits table
function populateDepositTable(deposits) {
    const tableBody = document.getElementById('deposit-table-body');
    tableBody.innerHTML = '';

    deposits.forEach((deposit, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}.</td>
            <td>${deposit.date}</td>
            <td>${deposit.category}</td>
            <td>${deposit.description}</td>
            <td>₱ ${parseFloat(deposit.amount).toFixed(2)}</td>
        `;
        tableBody.appendChild(row);
    });
}

// Populate the expenses table
function populateExpenseTable(expenses) {
    const tableBody = document.getElementById('expense-table-body');
    tableBody.innerHTML = '';

    expenses.forEach((expense, index) => {
        const items = expense.item.split(',').map(item => `<li>${item.trim()}</li>`).join('');

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}.</td>
            <td>${expense.date}</td>
            <td>${expense.category}</td>
            <td>${expense.description}</td>
            <td><ul>${items}</ul></td>
            <td>${expense.quantity}</td>
            <td>₱ ${parseFloat(expense.amount).toFixed(2)}</td>
        `;
        tableBody.appendChild(row);
    });
}

function toggleFilterOptions(filterType, tabType) {
    const filterContainer = document.getElementById(`${tabType}-filters`);
    const allFilters = filterContainer.querySelectorAll('.filter-option');
    
    // Hide all filter options
    allFilters.forEach(filter => filter.style.display = 'none');
    
    // Display the selected filter option
    const selectedFilter = document.getElementById(`${tabType}-${filterType}-filter`);
    if (selectedFilter) selectedFilter.style.display = 'block';
}

</script>
