<div class="app_header d-flex flex-row justify-content-between align-items-center">
    <h1>Expenses</h1>
    <button class="btn btn-create" id="create-expense-btn" onclick="openExpenseModal()">+ Create Expense Record</>

</div>

<div class="app_body">
    <div class="search-container mb-2">
        <input type="text" id="search-bar" class="form-control" placeholder="Search Transaction / Date" oninput="searchTable()">
    </div>

    <!-- Month and Year input fields -->
    <div class="col-12" style="margin: 0;">
        <div class="row" style="margin: 0 5px;">
            <div class="total-section col-6" >
                <div class="row d-flex mb-2">
                    <div class="filter-buttons d-flex">
                        <h4 style="margin: 0; margin-right: 10px;">Filters: </h4>
                        <button class="btn filter-btn" onclick="toggleFilterOptions('all', 'expense')">All</button>
                        <button class="btn filter-btn" onclick="toggleFilterOptions('month', 'expense')">Month</button>
                        <button class="btn filter-btn" onclick="toggleFilterOptions('category', 'expense')">Category</button>
                        <button class="btn filter-btn" onclick="toggleFilterOptions('dateRange', 'expense')">Date Range</button>
                    </div>
                </div>
                
                <div class="row d-flex mb-2">
                    <!-- Filter Options (hidden by default) -->
                    <div id="expense-filters" class="filter-options d-flex">
                        <!-- Month Filter -->
                        <div id="expense-month-filter" class="filter-option" style="display: none;">

                            <label for="expense-year-select">Select Year:</label>
                            <select id="expense-year-select">
                                <!-- Add more months as needed -->
                            </select>

                            <label for="expense-month-select">Select Month:</label>
                            <select id="expense-month-select">
                                <!-- Add more months as needed -->
                            </select>

                            <button class="btn filter-btn btn-outline-primary" onclick="applyFilter('month', 'expense')">Apply</button>
                        </div>

                        <!-- Category Filter -->
                        <div id="expense-category-filter" class="filter-option" style="display: none;">
                            <label for="expense-category-select">Select Category:</label>
                            <select id="expense-category-select">
                                <!-- Add more categories as needed -->
                            </select>
                            <button class="btn filter-btn btn-outline-primary" onclick="applyFilter('category', 'expense')">Apply</button>
                        </div>

                        <!-- Date Range Filter -->
                        <div id="expense-dateRange-filter" class="filter-option" style="display: none;">
                            
                            <label for="expense-start-date">Start Date:</label>
                            <input type="date" id="expense-start-date">
                        
                            <label for="expense-end-date">End Date:</label>
                            <input type="date" id="expense-end-date">
                                            
                            <button class="btn filter-btn btn-outline-primary" onclick="applyFilter('dateRange', 'expense')">Apply</button>
                            
                        </div>

                    </div>

                </div>
            </div>
            <div class="total-section col-6">
                <h2>Total:</h2><span id="expense-total-amount">0.00</span>
            </div>
        </div>
        
    </div>

    <div class="expense-report-title report-title" style="color: #fff;">
        <p id="expense-description">All expense records</p>
    </div>

    <!-- Scrollable Table -->
    
    <div class="table_container" style="height: calc(100% - 140px);">
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
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

