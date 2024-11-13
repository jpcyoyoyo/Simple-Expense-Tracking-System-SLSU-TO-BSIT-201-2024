            <div class="tab-pane fade show active" id="deposit" role="tabpanel" aria-labelledby="deposit-tab">
                <div class="tab-pane-head container">
                    <!-- Filter Buttons -->
                    <div class="row d-flex justify-content-center align-items-center mb-2">
                        <div class="filter-buttons d-flex justify-content-center align-items-center">
                            <h4 style="margin: 0; margin-right: 10px;">Filters: </h4>
                            <button class="btn filter-btn btn-outline-primary" onclick="toggleFilterOptions('all', 'deposit')">All</button>
                            <button class="btn filter-btn btn-outline-primary" onclick="toggleFilterOptions('month', 'deposit')">Month</button>
                            <button class="btn filter-btn btn-outline-primary" onclick="toggleFilterOptions('category', 'deposit')">Category</button>
                            <button class="btn filter-btn btn-outline-primary" onclick="toggleFilterOptions('dateRange', 'deposit')">Date Range</button>
                            <div style="margin-right: 10px; width: 1px; height: 24px; border-width: 1px; border-color: #43B6D6FF; border-style: solid;"></div>
                            <h4 style="margin: 0; margin-right: 10px;">Generate: </h4>
                            <button class="btn filter-btn btn-primary" onclick="generateReportDocument('deposit')" style="width: 100px;">Generate PDF</button>
                        </div>
                    </div>
                    
                    <div class="row d-flex justify-content-center align-items-center mb-2">
                        <!-- Filter Options (hidden by default) -->
                        <div id="deposit-filters" class="filter-options d-flex justify-content-center">
                            <!-- Month Filter -->
                            <div id="deposit-month-filter" class="filter-option" style="display: none;">

                                <label for="deposit-year-select">Select Year:</label>
                                <select id="deposit-year-select">
                                    <!-- Add more months as needed -->
                                </select>

                                <label for="deposit-month-select">Select Month:</label>
                                <select id="deposit-month-select">
                                    <!-- Add more months as needed -->
                                </select>

                                <button class="btn filter-btn btn-outline-primary" onclick="applyFilter('month', 'deposit')">Apply</button>
                            </div>

                            <!-- Category Filter -->
                            <div id="deposit-category-filter" class="filter-option" style="display: none;">
                                <label for="deposit-category-select">Select Category:</label>
                                <select id="deposit-category-select">
                                    <!-- Add more categories as needed -->
                                </select>
                                <button class="btn filter-btn btn-outline-primary" onclick="applyFilter('category', 'deposit')">Apply</button>
                            </div>

                            <!-- Date Range Filter -->
                            <div id="deposit-dateRange-filter" class="filter-option" style="display: none;">
                                
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
                                    <!-- Initial empty table. Rows will be added dynamically. -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
