<div class="app_header d-flex flex-row justify-content-between align-items-center">
    <h1>Deposits</h1>
    <button class="btn btn-create" id="create-deposit-btn" onclick="openDepositModal()">+ Create Deposit Record</button>

</div>

<div class="app_body">
    <!-- Search Bar -->
    <div class="search-container mb-2">
        <input type="text" id="search-bar" class="form-control" placeholder="Search Deposits..." oninput="searchTable()" />
    </div>

    <!-- Month and Year input fields -->
    <p class="col-12" style="margin: 0;">
        <div class="row">
            <div class="total-section col-6" >
                <h2>Month:</h2><input type="month" class="month-year-input" id="month-input" value="2024-01" />
            </div>
            <div class="total-section col-6">
                <h2>Total:</h2><span id="deposit-total-amount">0.00</span>
            </div>
        </div>
        
    </p>

    <div class="table_container" style="height: calc(100% - 140px);">
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
                            <th>ACTION</th>
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


