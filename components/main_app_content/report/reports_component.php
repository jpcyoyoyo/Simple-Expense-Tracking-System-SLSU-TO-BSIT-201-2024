<div class="app_header d-flex flex-row justify-content-between align-items-center">
    <h1>Generate Reports</h1>
</div>

<div class="app_body container-fluid">
    <div class="report-container">
        <!-- Tab Navigation with Full-Width Tabs -->
        <ul class="nav nav-tabs d-flex" id="reportTabs" role="tablist">
            <li class="tab-nav-item flex-fill" role="presentation">
                <button class="tab-nav-link active w-100" id="deposit-tab" data-bs-toggle="tab" data-bs-target="#deposit" type="button" role="tab" aria-controls="deposit" aria-selected="true">Deposit</button>
            </li>
            <li class="tab-nav-item flex-fill" role="presentation">
                <button class="tab-nav-link w-100" id="expense-tab" data-bs-toggle="tab" data-bs-target="#expense" type="button" role="tab" aria-controls="expense" aria-selected="false">Expense</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="reportTabsContent">
            <!-- Deposit Tab Pane -->
            <?php include "components/main_app_content/report/deposit_report_tab.php"?>

            <!-- Expense Tab Pane -->
            <?php include "components/main_app_content/report/expense_report_tab.php"?>
            
        </div>
    </div>
</div>

