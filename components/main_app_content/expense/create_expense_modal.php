<!-- Modal for Create Deposit Record -->
<div id="expense-modal" class="modal" style="padding-left: 250px; background-color: rgba(0, 0, 0, 0.725);">
    <div class="modal-content">
        <div class="close" onclick="closeExpenseModal()">&times;</div>
        <h1>Create Expense Record</h1>

        <form id="create-expense-form" onsubmit="addExpenseRecord(event)">
            <div class="form-grid col-12">
                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="description">Description</label>
                        <input type="text" id="create_expense_description" class="form-control" placeholder="Enter description" required />
                    </div>

                    <!-- Date in the second column -->
                    <div class="form-group col-lg-6">
                        <label for="date">Date</label>
                        <input type="date" id="create_expense_date" class="form-control" required />
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="category">Category</label>
                        <select id="create_expense_category" class="form-control" required>
                            <!-- Add categories as options -->
                        </select>
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="item">Item</label>
                        <input type="text" id="create_expense_item" class="form-control" placeholder="Enter item" required />
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="quantity">Quantity</label>
                        <input type="number" id="create_expense_quantity" class="form-control" placeholder="Enter quantity" required />
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="amount">Amount</label>
                        <input type="number" id="create_expense_amount" class="form-control" placeholder="Enter amount" step="0.01" required />
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="receipt">Receipt</label>
                        <input type="file" id="create_expense_receipt" class="form-control" />
                    </div>
                </div>
                

                <!-- Submit button aligned to the second column -->
                <div class="row row-no-gutters">
                    <div class="form-group-full col-lg-6 offset-lg-6 d-flex justify-content-end align-items-end">
                        <button type="submit" class="btn_submit-primary">Add Expenses</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
