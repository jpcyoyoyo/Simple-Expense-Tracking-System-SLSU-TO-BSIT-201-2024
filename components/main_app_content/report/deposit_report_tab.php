<div class="tab-pane fade show active" id="deposit" role="tabpanel" aria-labelledby="deposit-tab">
    <div class="tab-pane-head container">
        <!-- Filter Buttons -->
        <div class="row d-flex justify-content-center align-items-center mb-2">
            <div class="filter-buttons d-flex justify-content-center align-items-center">
                <!-- Filters Dropdown -->
                <div class="dropdown me-2">
                    <button class="btn filter-btn btn-primary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Filters
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                        <li><a class="dropdown-item" href="#filter-all" onclick="toggleFilterOptions('all', 'deposit')">All</a></li>
                        <li><a class="dropdown-item" href="#filter-month" onclick="toggleFilterOptions('month', 'deposit')">Month</a></li>
                        <li><a class="dropdown-item" href="#filter-category" onclick="toggleFilterOptions('category', 'deposit')">Category</a></li>
                        <li><a class="dropdown-item" href="#filter-date-range" onclick="toggleFilterOptions('dateRange', 'deposit')">Date Range</a></li>
                    </ul>
                </div>
                <div style="margin-right: 10px; width: 1px; height: 24px; border-width: 1px; border-color: #43B6D6FF; border-style: solid;"></div>
                <button class="btn filter-btn btn-primary" onclick="generateReportDocument('deposit')" style="width: 100px;">Generate PDF</button>
            </div>
        </div>
        
        <!-- Filter Options (hidden by default) -->
        <div class="row d-flex justify-content-center align-items-center mb-2" id="deposit-filters" style="display: none;">
            <div class="filter-options d-flex justify-content-center align-items-center">
                <!-- Month Filter -->
                <div id="deposit-month-filter" class="filter-option me-3" style="display: none;">
                    <label for="deposit-year-select">Select Year:</label>
                    <select id="deposit-year-select">
                        <!-- Add years dynamically -->
                    </select>

                    <label for="deposit-month-select">Select Month:</label>
                    <select id="deposit-month-select">
                        <!-- Add months dynamically -->
                    </select>

                    <button class="btn filter-btn btn-outline-primary mt-2" onclick="applyFilter('month', 'deposit')">Apply</button>
                </div>

                <!-- Category Filter -->
                <div id="deposit-category-filter" class="filter-option me-3" style="display: none;">
                    <label for="deposit-category-select">Select Category:</label>
                    <select id="deposit-category-select">
                        <!-- Add categories dynamically -->
                    </select>
                    <button class="btn filter-btn btn-outline-primary mt-2" onclick="applyFilter('category', 'deposit')">Apply</button>
                </div>

                <!-- Date Range Filter -->
                <div id="deposit-dateRange-filter" class="filter-option me-3" style="display: none;">
                    <label for="deposit-start-date">Start Date:</label>
                    <input type="date" id="deposit-start-date">

                    <label for="deposit-end-date">End Date:</label>
                    <input type="date" id="deposit-end-date">
                    
                    <button class="btn filter-btn btn-outline-primary" onclick="applyFilter('dateRange', 'deposit')">Apply</button>
                </div>
            </div>
        </div>
    
        <div class="deposit-report-title report-title">
            <h2>Deposit Report</h2>
            <p id="deposit-report-description">All deposit records</p>
            <div class="total-section d-flex justify-content-center align-items-center">
                <p>Total:</p><span id="deposit-total-amount">0.00</span>
            </div>
        </div>
    </div>

    <div class="report-table-container deposit-table">
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
                        <!-- Table rows will be dynamically added here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
