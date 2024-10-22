
<div class="app_header d-flex flex-row justify-content-between align-items-center">
    <h1>Deposits</h1>
    <button class="btn btn-create" id="create-deposit-btn" onclick="openDepositModal()">+ Create Expense Record</button>

</div>

<div class="app_body">
    <!-- Search Bar -->
    <div class="search-container mt-3 mb-4">
        <input type="text" id="search-bar" class="form-control" placeholder="Search Deposits..." oninput="searchTable()" />
    </div>

    <!-- Month and Year input fields -->
    <p><strong>Month:</strong>
        <input type="month" class="month-year-input" id="month-input" value="2024-01" />
    </p>

    <div class="table_container">
        <div class="table-wrapper">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Name of Transaction</th>
                            <th>Amount (₱)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <!-- Initial empty table. Rows will be added dynamically. -->
                    </tbody>
                </table>

                <div class="total-section">
                    <strong>Total:</strong> ₱<span id="total-amount">0.00</span>
                </div>
            </div>
        </div>
    </div>
</div>


