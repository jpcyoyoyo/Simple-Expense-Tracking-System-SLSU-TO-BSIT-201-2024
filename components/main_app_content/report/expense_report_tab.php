            <div class="tab-pane fade" id="expense" role="tabpanel" aria-labelledby="expense-tab">
                <div class="tab-pane-head container">
                    <!-- Filter Buttons -->
                    <div class="row d-flex justify-content-center align-items-center mb-2">
                        <div class="filter-buttons d-flex justify-content-center align-items-center">
                            <h4 style="margin: 0; margin-right: 10px;">Filters: </h4>
                            <button class="btn filter-btn btn-outline-primary" onclick="toggleFilterOptions('all', 'expense')">All</button>
                            <button class="btn filter-btn btn-outline-primary" onclick="toggleFilterOptions('month', 'expense')">Month</button>
                            <button class="btn filter-btn btn-outline-primary" onclick="toggleFilterOptions('category', 'expense')">Category</button>
                            <button class="btn filter-btn btn-outline-primary" onclick="toggleFilterOptions('dateRange', 'expense')">Date Range</button>
                            <div style="margin-right: 10px; width: 1px; height: 24px; border-width: 1px; border-color: #43B6D6FF; border-style: solid;"></div>
                            <h4 style="margin: 0; margin-right: 10px;">Generate: </h4>
                            <button class="btn filter-btn btn-primary" onclick="generateReportDocument('expense')" style="width: 100px;">Generate PDF</button>
                        </div>
                    </div>
                    
                    <div class="row d-flex justify-content-center align-items-center mb-2">
                        <!-- Filter Options (hidden by default) -->
                        <div id="expense-filters" class="filter-options d-flex justify-content-center">
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
                
                    <div class="expense-report-title report-title">
                        <h2>Expense Report</h2>
                        <p id="expense-report-description">All expense records</p>
                        <div class="total-section d-flex justify-content-center align-items-center">
                            <p>Total: </p><span id="expense-total-amount">0.00</span>
                        </div>
                    </div>
                </div>

                <div class="report-table-container expense-table">
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
