<!-- Modal for Create Deposit Record -->
<div id="edit-deposit-modal" class="modal" style="padding-left: 250px; background-color: rgba(0, 0, 0, 0.725);">
    <div class="modal-content">
        <span class="close" onclick="closeEditDepositModal()">&times;</span>
        <h1>Edit Deposit Record</h1>

        <form id="update-deposit-form" onsubmit="updateDeposit(event)">
            <input type="hidden" id="deposit-id">
            <div class="form-grid col-12">
                <div class="row">
                    <div class="form-group col-xl-6">
                        <label for="description">Description</label>
                        <input type="text" id="edit_deposit_description" class="form-control" placeholder="Enter description" required />
                    </div>

                    <!-- Date in the second column -->
                    <div class="form-group col-xl-6">
                        <label for="date">Date</label>
                        <input type="date" id="edit_deposit_date" class="form-control" required />
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xl-6">
                        <label for="category">Category</label>
                        <select id="edit_deposit_category" class="form-control" required>
                            <!-- Add more categories as options -->
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xl-6">
                        <label for="amount">Amount</label>
                        <input type="number" id="edit_deposit_amount" class="form-control" placeholder="Enter amount" step="0.01" required />
                    </div>
                </div>

                <div class="row">
                    <div class="form-group-full col-xl-12 d-flex justify-content-end align-items-end">
                        <button type="submit" class="btn_submit-primary">Edit Deposit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

