<!-- Modal for View User Account -->
<div id="view-user-modal" class="modal" style="padding-left: 250px; background-color: rgba(0, 0, 0, 0.725);">
    <div class="modal-content">
        <span class="close" onclick="closeViewAccountModal()">&times;</span>
        <div class="d-flex flex-row justify-content-between align-items-center">
            <h1>View User Account</h1>
            <h4 id="view-user-is_login"></h4>
        </div>

        <div id="view-user-details">
            <div class="form-grid col-12">
                <div class="row row-no-gutters">
                    <div class="col-lg-6">
                        <div class="row flex-column align-items-center">
                            <div class="profile-pic-container mb-3">
                                <!-- Display image inside the frame -->
                                <img id="view-user-profile-pic" src="" alt="Profile Picture"> 
                            </div>
                        </div>
                    </div>

                    <div class="form-content col-lg-6" style="padding: 0 40px;">
                        <div class="form-group">
                            <div class="col-md-5">
                                <h6>User ID: </h6>
                            </div>

                            <div class="col-md-7">
                                <h6 id="view-user-id"></h6>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-5">
                                <h6>Username: </h6>
                            </div>

                            <div class="col-md-7">
                                <h6 id="view-user-username"></h6>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-5">
                                <h6>Full Name: </h6>
                            </div>

                            <div class="col-md-7">
                                <h6 id="view-user-fullname"></h6>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-5">
                                <h6>Email: </h6>
                            </div>

                            <div class="col-md-7">
                                <h6 id="view-user-email"></h6>
                            </div>
                    
                        </div>

                        <div class="form-group">
                            <div class="col-md-5">
                                <h6>User Account Created:  </h6>
                            </div>

                            <div class="col-md-7">
                                <h6 id="view-user-created_at"></h6>
                            </div>
                
                        </div>

                        <div class="form-group">
                            <div class="col-md-5">
                                <h6>User Account Updated:  </h6>
                            </div>

                            <div class="col-md-7">
                                <h6 id="view-user-updated_at"></h6>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group col-lg-12 d-flex justify-content-end">
                        <button type="button" class="btn_submit-primary" style="margin: 0 10px;" onclick="editUser()">Edit</button>
                        <button type="button" class="btn_submit-primary" onclick="deleteUserAccount()">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="main_container" style="height: auto;">
            <div class="row gx-3 gy-2">
                <!-- Search Bar -->
                <div class="col-xl-7">
                    <input type="text" id="user-logs-search-bar" class="form-control mb-2" placeholder="Search Logs..." oninput="searchTable('user-logs')" />
                    <div>
                        <h5 class="user-logs-total-section">Total: <span id="user-logs-total-amount" class="ms-2">0</span></h5>
                    </div>
                </div>

                <!-- Filters Section -->
                <div class="col-xl-5 d-flex flex-row align-items-top">
                    <!-- Filters Dropdown -->
                    <div class="dropdown ms-8 col-md-3">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Filters
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                            <li><a class="dropdown-item" href="#user-logs-filter-all" onclick="toggleFilterOptions('all', 'user-logs')">All</a></li>
                            <li><a class="dropdown-item" href="#user-logs-filter-month" onclick="toggleFilterOptions('month', 'user-logs')">Month</a></li>
                            <li><a class="dropdown-item" href="#user-logs-filter-date-range" onclick="toggleFilterOptions('dateRange', 'user-logs')">Date Range</a></li>
                        </ul>
                    </div>

                    <!-- Filter Options (hidden by default) -->
                    <div id="user-logs-filters" class="flex flex-wrap col-md-7">
                        <!-- Month Filter -->
                        <div id="user-logs-month-filter" class="filter-option me-3" style="display: none;">
                            <div class="row align-items-center mb-2">
                                <div class="col-md-4" style="padding: 0 2px"> 
                                    <label for="user-logs-year-select" class="form-label" style="margin: 0;">Year:</label>
                                </div>
                                <div class="col-md-8" style="padding: 0 2px">
                                    <select id="user-logs-year-select">
                                        <!-- Add years -->
                                    </select>
                                </div>
                            </div>

                            <div class="row align-items-center mb-2">
                                <div class="col-md-4" style="padding: 0 2px">
                                    <label for="user-logs-month-select" class="form-label" style="margin: 0;">Month:</label>
                                </div>
                                <div class="col-md-8" style="padding: 0 2px">
                                    <select id="user-logs-month-select">
                                        <!-- Add months -->
                                    </select>
                                </div>
                            </div>

                            <div class="justify-content-end align-items-end">
                                <button class="btn btn-md btn-outline-primary filter-btn" onclick="applyFilter('month', 'user-logs')">Apply</button>
                            </div>
                        </div>

                        <!-- Date Range Filter -->
                        <div id="user-logs-dateRange-filter" class="filter-option me-3" style="display: none;">
                            <div class="row align-items-center mb-2">
                                <div class="col-md-4" style="padding: 0 2px">
                                    <label for="start-date" class="form-label" style="margin: 0;">Start Date:</label>
                                </div>
                                <div class="col-md-8" style="padding: 0 2px">
                                    <input type="date" id="user-logs-start-date">
                                </div>
                            </div>
                            <div class="row align-items-center mb-2">
                                <div class="col-md-4" style="padding: 0 2px">
                                    <label for="end-date" class="form-label" style="margin: 0;">End Date:</label>
                                </div>
                                <div class="col-md-8" style="padding: 0 2px">
                                    <input type="date" id="user-logs-end-date">
                                </div>
                            </div>
                            <div class="justify-content-end align-items-end">
                                <button class="btn btn-md btn-outline-primary filter-btn" onclick="applyFilter('dateRange', 'user-logs')">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Title -->
            <div class="user-logs-report-title report-title text-center">
                <p id="user-logs-description" class="mb-0">All logs</p>
            </div>

            <!-- Table Section -->
            <div class="main_container" style="height: 300px; margin: 10px 0;">
                <div class="table-wrapper">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>LOG ID</th>
                                    <th>DATE CREATED</th>
                                    <th>LOG DESCRIPTION</th>
                                </tr>
                            </thead>
                            <tbody id="user-logs-table-body">
                                <!-- Additional rows can go here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

