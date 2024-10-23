<!-- Modal for Create Deposit Record -->
<div id="expense-modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeExpenseModal()">&times;</span>
        <h1>Create Expense Record</h1>

        <form id="deposit-form" onsubmit="addExpenseRecord(event)">
            <div class="form-grid col-12">
                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="description">Description</label>
                        <input type="text" id="description" class="form-control" placeholder="Enter description" required />
                    </div>

                    <!-- Date in the second column -->
                    <div class="form-group col-lg-6">
                        <label for="date">Date</label>
                        <input type="date" id="date" class="form-control" required />
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="category">Category</label>
                        <select id="category" class="form-control" required>
                            <option value="">Select Category</option>
                            <option value="Category 1">Category 1</option>
                            <option value="Category 2">Category 2</option>
                            <!-- Add categories as options -->
                        </select>
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="item">Item</label>
                        <input type="text" id="item" class="form-control" placeholder="Enter item" required />
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="quantity">Quantity</label>
                        <input type="number" id="quantity" class="form-control" placeholder="Enter quantity" required />
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="amount">Amount</label>
                        <input type="number" id="amount" class="form-control" placeholder="Enter amount" step="0.01" required />
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="receipt">Receipt</label>
                        <input type="file" id="receipt" class="form-control" />
                    </div>
                </div>
                

                <!-- Submit button aligned to the second column -->
                <div class="row row-no-gutters">
                    <div class="form-group-full col-lg-6 offset-lg-6 d-flex justify-content-end align-items-end">
                        <button type="submit" class="btn_deposit-primary">Add Expenses</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
