<div class="app_header d-flex flex-row justify-content-between align-items-center">
    <h1>Categories</h1>
    <button class="btn btn-create" id="create-category-btn" onclick="openCategoryModal()">+ Create Category</button>

</div>

<div class="app_body">
    <!-- Search Bar -->
    <div class="main_container" style="height: auto;">
        <!-- Search Bar and Total -->
        <div class="row gx-3 gy-2">
            <!-- Search Bar -->
            <div class="col-xl-7">
                <input type="text" id="search-bar" class="form-control mb-2" placeholder="Search Category..." oninput="searchTable()" />
                <div>
                    <h5 class="total-section">Total: <span id="category-total-amount" class="ms-2">0.00</span></h5>
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
                        <li><a class="dropdown-item" href="#" onclick="toggleFilterOptions('all', 'category')">All</a></li>
                        <li><a class="dropdown-item" href="#" onclick="toggleFilterOptions('month', 'category')">Month</a></li>
                        <li><a class="dropdown-item" href="#" onclick="toggleFilterOptions('dateRange', 'category')">Date Range</a></li>
                    </ul>
                </div>

                <!-- Filter Options (hidden by default) -->
                <div id="category-filters" class="flex flex-wrap col-sm-7">
                    <!-- Month Filter -->
                    <div id="category-month-filter" class="filter-option me-3" style="display: none;">
                        <div class="row align-items-center mb-2">
                            <div class="col-sm-4" style="padding: 0 2px"> 
                                <label for="category-year-select" class="form-label" style="margin: 0;">Year:</label>
                            </div>
                            <div class="col-sm-8" style="padding: 0 2px">
                                <select id="category-year-select">
                                    <!-- Add years -->
                                </select>
                            </div>
                        </div>

                        <div class="row align-items-center mb-2">
                            <div class="col-sm-4" style="padding: 0 2px">
                                <label for="category-month-select" class="form-label" style="margin: 0;">Month:</label>
                            </div>
                            <div class="col-sm-8" style="padding: 0 2px">
                                <select id="category-month-select">
                                    <!-- Add months -->
                                </select>
                            </div>
                        </div>

                        <div class="justify-content-end align-items-end">
                            <button class="btn btn-sm btn-outline-primary filter-btn" onclick="applyFilter('month', 'category')">Apply</button>
                        </div>
                        
                    </div>

                    <!-- Date Range Filter -->
                    <div id="category-dateRange-filter" class="filter-option me-3" style="display: none;">
                        <div class="row align-items-center mb-2">
                            <div class="col-sm-4" style="padding: 0 2px">
                                <label for="category-start-date" class="form-label" style="margin: 0;"></label>Start Date:</label>
                            </div>
                            <div class="col-sm-8" style="padding: 0 2px">
                                <input type="date" id="category-start-date">
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-sm-4" style="padding: 0 2px">
                                <label for="category-end-date" class="form-label" style="margin: 0;">End Date:</label>
                            </div>
                            <div class="col-sm-8" style="padding: 0 2px">
                                <input type="date" id="category-end-date">
                            </div>
                        </div>
                        <div class="justify-content-end align-items-end">
                            <button class="btn btn-sm btn-outline-primary filter-btn" onclick="applyFilter('dateRange', 'category')">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Title -->
        <div class="category-report-title report-title text-center">
            <p id="category-description" class="mb-0">All categories</p>
        </div>

        <!-- Table Section -->
        <div class="main_container" style="height: 400px; margin: 10px 0;">
            <div class="table-wrapper">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>NO.</th>
                                <th>DATE</th>
                                <th>CATEGORY NAME</th>
                                <th>DESCRIPTION</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="category-table-body">
                            <!-- Initial empty table. Rows will be added dynamically. -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
