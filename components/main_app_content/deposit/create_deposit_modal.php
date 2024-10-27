<!-- Modal for Create Deposit Record -->
<div id="deposit-modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeDepositModal()">&times;</span>
        <h1>Create Deposit Record</h1>

        <form id="create-deposit-form" onsubmit="addDepositRecord(event)">
            <div class="form-grid col-12">
                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="description">Description</label>
                        <input type="text" id="create_deposit_description" class="form-control" placeholder="Enter description" required />
                    </div>

                    <!-- Date in the second column -->
                    <div class="form-group col-lg-6">
                        <label for="date">Date</label>
                        <input type="date" id="create_deposit_date" class="form-control" required />
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="category">Category</label>
                        <select id="create_deposit_category" class="form-control" required>
                            <option value="">Select Category</option>
                            <option value="Category 1">Category 1</option>
                            <option value="Category 2">Category 2</option>
                            <!-- Add more categories as options -->
                        </select>
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="amount">Amount</label>
                        <input type="number" id="create_amountdeposit_" class="form-control" placeholder="Enter amount" step="0.01" required />
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group-full col-lg-12 d-flex justify-content-end align-items-end">
                        <button type="submit" class="btn_submit-primary">Add Deposit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

