<div class="app_header d-flex flex-row justify-content-between align-items-center">
    <h1>Expenses</h1>
    <button class="btn btn-create" id="create-expense-btn" onclick="openExpenseModal()">+ Create Expense Record</>

</div>

<div class="app_body">
    <div class="search-container mb-2">
        <input type="text" id="search-bar" class="form-control" placeholder="Search Transaction / Date" oninput="searchTable()">
    </div>

    <div class="container-fluid flex-row">
        <div class="filter-settings row">
            <div class="col-6">
                <div class="d-flex mb-3" style="margin-bottom: 0 !important;">
                    <button class="btn btn-category btn-outline-info me-2">All 50</button>
                    <button class="btn btn-category btn-outline-info">Month</button>
                </div>

                <!-- Dropdown for months -->
                <div class="dropdown">
                    <button class="btn btn-dropdown dropdown-toggle" type="button" id="menu1" data-bs-toggle="dropdown" aria-expanded="false">
                        Select Month
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="menu1">
                        <li><a class="dropdown-item" href="#">FEBRUARY</a></li>
                        <li><a class="dropdown-item" href="#">MARCH</a></li>
                        <li><a class="dropdown-item" href="#">APRIL</a></li>
                        <li><a class="dropdown-item" href="#">MAY</a></li>
                        <li><a class="dropdown-item" href="#">JUNE</a></li>
                        <li><a class="dropdown-item" href="#">JULY</a></li>
                        <li><a class="dropdown-item" href="#">AUGUST</a></li>
                        <li><a class="dropdown-item" href="#">SEPTEMBER</a></li>
                        <li><a class="dropdown-item" href="#">OCTOBER</a></li>
                        <li><a class="dropdown-item" href="#">NOVEMBER</a></li>
                        <li><a class="dropdown-item" href="#">DECEMBER</a></li>
                    </ul>
                </div>
            </div>

            <div class="total-section col-6">
                <h2>Total:</h2><span id="expense-total-amount">0.00</span>
            </div>
        </div>
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

