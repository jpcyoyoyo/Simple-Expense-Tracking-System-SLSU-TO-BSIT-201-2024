<div class="app_header d-flex flex-row justify-content-between align-items-center">
    <h1>Expenses</h1>
    <button class="btn btn-create" id="create-expense-btn" onclick="openExpenseModal()">+ Create Expense Record</button>
</div>

<div class="app_body">
    <!-- Search Bar and Total -->
    <div class="main_container" style="height: auto;">
        <div class="row gx-3 gy-2">
            <!-- Search Bar -->
            <div class="col-xl-7">
                <input type="text" id="search-bar" class="form-control mb-2" placeholder="Search Expenses..." oninput="searchTable()" />
                <div>
                    <h5 class="total-section">Total: <span id="expense-total-amount" class="ms-2">0.00</span></h5>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="col-xl-5 d-flex flex-row align-items-top">
                <!-- Filters Dropdown -->
                <div class="dropdown ms-8 col-sm-3">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Filters
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                        <li><a class="dropdown-item" href="#filter-all" onclick="toggleFilterOptions('all', 'expense')">All</a></li>
                        <li><a class="dropdown-item" href="#filter-month" onclick="toggleFilterOptions('month', 'expense')">Month</a></li>
                        <li><a class="dropdown-item" href="#filter-category" onclick="toggleFilterOptions('category', 'expense')">Category</a></li>
                        <li><a class="dropdown-item" href="#filter-date-range" onclick="toggleFilterOptions('dateRange', 'expense')">Date Range</a></li>
                    </ul>
                </div>

                <!-- Filter Options (hidden by default) -->
                <div id="expense-filters" class="flex flex-wrap col-sm-7">
                    <!-- Month Filter -->
                    <div id="expense-month-filter" class="filter-option me-3" style="display: none;">
                        <div class="row align-items-center mb-2">
                            <div class="col-sm-4" style="padding: 0 2px"> 
                                <label for="expense-year-select" class="form-label" style="margin: 0;">Year:</label>
                            </div>
                            <div class="col-sm-8" style="padding: 0 2px">
                                <select id="expense-year-select">
                                    <!-- Add years -->
                                </select>
                            </div>
                        </div>

                        <div class="row align-items-center mb-2">
                            <div class="col-sm-4" style="padding: 0 2px">
                                <label for="expense-month-select" class="form-label" style="margin: 0;">Month:</label>
                            </div>
                            <div class="col-sm-8" style="padding: 0 2px">
                                <select id="expense-month-select">
                                    <!-- Add months -->
                                </select>
                            </div>
                        </div>

                        <div class="justify-content-end align-items-end">
                            <button class="btn btn-sm btn-outline-primary filter-btn" onclick="applyFilter('month', 'expense')">Apply</button>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div id="expense-category-filter" class="filter-option me-3" style="display: none;">
                        <div class="row align-items-center mb-2">
                            <div class="col-sm-4" style="padding: 0 2px">
                                <label for="expense-category-select" class="form-label" style="margin: 0;">Category:</label>
                            </div>
                            <div class="col-sm-8" style="padding: 0 2px">
                                <select id="expense-category-select">
                                    <!-- Add categories -->
                                </select>
                            </div>
                        </div>
                        <div class="justify-content-end align-items-end">
                            <button class="btn btn-sm btn-outline-primary filter-btn" onclick="applyFilter('category', 'expense')">Apply</button>
                        </div>
                    </div>

                    <!-- Date Range Filter -->
                    <div id="expense-dateRange-filter" class="filter-option me-3" style="display: none;">
                        <div class="row align-items-center mb-2">
                            <div class="col-sm-4" style="padding: 0 2px">
                                <label for="expense-start-date" class="form-label" style="margin: 0;">Start Date:</label>
                            </div>
                            <div class="col-sm-8" style="padding: 0 2px">
                                <input type="date" id="expense-start-date">
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-sm-4" style="padding: 0 2px">
                                <label for="expense-end-date" class="form-label" style="margin: 0;">End Date:</label>
                            </div>
                            <div class="col-sm-8" style="padding: 0 2px">
                                <input type="date" id="expense-end-date">
                            </div>
                        </div>
                        <div class="justify-content-end align-items-end">
                            <button class="btn btn-sm btn-outline-primary filter-btn" onclick="applyFilter('dateRange', 'expense')">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Title -->
        <div class="expense-report-title report-title text-center">
            <p id="expense-description" class="mb-0">All expense records</p>
        </div>

        <!-- Table Section -->
        <div class="main_container" style="height: calc(100% - 140px); margin: 10px 0;">
            <div class="table-wrapper">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>NO.</th>
                                <th>DATE</th>
                                <th>CATEGORY</th>
                                <th>DESCRIPTION</th>
                                <th>ITEMS</th>
                                <th>QTY</th>
                                <th>AMOUNT (₱)</th>
                                <th>ACTION</th>
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
