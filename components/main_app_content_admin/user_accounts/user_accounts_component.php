<div class="app_header d-flex flex-row justify-content-between align-items-center">
    <h1>User Accounts List</h1>
    <button class="btn btn-create" id="create-account-btn" onclick="openAccountModal()">+ Create Account</button>
</div>

<div class="app_body">
    <!-- Search Bar and Total -->
    <div class="main_container" style="height: auto;">
        <div class="row gx-3 gy-2">
            <!-- Search Bar -->
            <div class="col-xl-7">
                <input type="text" id="users-search-bar" class="form-control mb-2" placeholder="Search User..." oninput="searchTable('users')" />
                <div>
                    <h5 class="total-section">Total: <span id="users-total-amount" class="ms-2">0</span></h5>
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
                        <li><a class="dropdown-item" href="#" onclick="toggleFilterOptions('all', 'users')">All</a></li>
                        <li><a class="dropdown-item" href="#" onclick="toggleFilterOptions('month', 'users')">Month</a></li>
                        <li><a class="dropdown-item" href="#" onclick="toggleFilterOptions('dateRange', 'users')">Date Range</a></li>
                    </ul>
                </div>

                <!-- Filter Options (hidden by default) -->
                <div id="users-filters" class="flex flex-wrap col-sm-7">
                    <!-- Month Filter -->
                    <div id="users-month-filter" class="filter-option me-3" style="display: none;">
                        <div class="row align-items-center mb-2">
                            <div class="col-sm-4" style="padding: 0 2px"> 
                                <label for="users-year-select" class="form-label" style="margin: 0;">Year:</label>
                            </div>
                            <div class="col-sm-8" style="padding: 0 2px">
                                <select id="users-year-select">
                                    <!-- Add years -->
                                </select>
                            </div>
                        </div>

                        <div class="row align-items-center mb-2">
                            <div class="col-sm-4" style="padding: 0 2px">
                                <label for="users-month-select" class="form-label" style="margin: 0;">Month:</label>
                            </div>
                            <div class="col-sm-8" style="padding: 0 2px">
                                <select id="users-month-select">
                                    <!-- Add months -->
                                </select>
                            </div>
                        </div>

                        <div class="justify-content-end align-items-end">
                            <button class="btn btn-sm btn-outline-primary filter-btn" onclick="applyFilter('month', 'users')">Apply</button>
                        </div>
                    </div>

                    <!-- Date Range Filter -->
                    <div id="users-dateRange-filter" class="filter-option me-3" style="display: none;">
                        <div class="row align-items-center mb-2">
                            <div class="col-sm-4" style="padding: 0 2px">
                                <label for="users-start-date" class="form-label" style="margin: 0;">Start Date:</label>
                            </div>
                            <div class="col-sm-8" style="padding: 0 2px">
                                <input type="date" id="users-start-date">
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-sm-4" style="padding: 0 2px">
                                <label for="users-end-date" class="form-label" style="margin: 0;">End Date:</label>
                            </div>
                            <div class="col-sm-8" style="padding: 0 2px">
                                <input type="date" id="users-end-date">
                            </div>
                        </div>
                        <div class="justify-content-end align-items-end">
                            <button class="btn btn-sm btn-outline-primary filter-btn" onclick="applyFilter('dateRange', 'users')">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Title -->
        <div class="users-report-title report-title text-center">
            <p id="users-description" class="mb-0">All users</p>
        </div>

        <!-- Table Section -->
        <div class="main_container" style="height: 400px; margin: 10px 0;">
            <div class="table-wrapper">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>NO.</th>
                                <th>USER ID</th>
                                <th>LOGIN STATUS</th>
                                <th>USERNAME</th>
                                <th>DATE CREATED</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="users-table-body">
                            <!-- Additional rows can go here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
