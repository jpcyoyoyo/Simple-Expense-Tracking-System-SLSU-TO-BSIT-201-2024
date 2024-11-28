<!-- Modal for Create Deposit Record -->
<div id="edit-expense-modal" class="modal" style="padding-left: 250px; background-color: rgba(0, 0, 0, 0.725);">
    <div class="modal-content">
        <span class="close" onclick="closeEditExpenseModal()">&times;</span>
        <h1>Create Expense Record</h1>

        <form id="update-expense-form" onsubmit="updateExpense(event)">
        <input type="hidden" id="expense-id">
            <div class="form-grid col-12">
                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="description">Description</label>
                        <input type="text" id="edit-expense-description" class="form-control" placeholder="Enter description" required />
                    </div>

                    <!-- Date in the second column -->
                    <div class="form-group col-lg-6">
                        <label for="date">Date</label>
                        <input type="date" id="edit-expense-date" class="form-control" required />
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="category">Category</label>
                        <select id="edit_expense_category" class="form-control" required>
                            <!-- Add categories as options -->
                        </select>
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="item">Item</label>
                        <input type="text" id="edit-expense-item" class="form-control" placeholder="Enter item" required />
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="quantity">Quantity</label>
                        <input type="number" id="edit-expense-quantity" class="form-control" placeholder="Enter quantity" required />
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="amount">Amount</label>
                        <input type="number" id="edit-expense-amount" class="form-control" placeholder="Enter amount" step="0.01" required />
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="receipt">Receipt</label>
                        <input type="file" id="edit-expense-receipt" class="form-control" />
                    </div>
                </div>
                

                <!-- Submit button aligned to the second column -->
                <div class="row row-no-gutters">
                    <div class="form-group-full col-lg-6 offset-lg-6 d-flex justify-content-end align-items-end">
                        <button type="submit" class="btn_submit-primary">Edit Expenses</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
