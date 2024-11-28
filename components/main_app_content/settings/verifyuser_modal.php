<!-- Modal for Verify User -->
<div id="verifyuser-modal" class="modal" style="padding-left: 250px; background-color: rgba(0, 0, 0, 0.725);">
    <div class="modal-content">
        <!-- Close Button -->
        <div class="close" onclick="closeVerifyUserModal()">&times;</div>
        
        <!-- Modal Header -->
        <h1>Verify User</h1>
        
        <!-- Verification Form -->
        <form id="verifyuser-form" onsubmit="verifyUser(event)" method="post">
            <!-- Security Questions -->
            <div class="form-grid col-12">
                <!-- Question 1 -->
                <div class="form-group row mt-3">
                    <div class="col-md-4">
                        <label for="q1" class="col-form-label">Question 1</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" id="q1" name="q1" class="form-control" value="" disabled>
                    </div>
                </div>
                <div class="form-group row mt-2">
                    <div class="offset-md-4 col-md-8">
                        <input type="text" name="q1_answer" class="form-control" placeholder="Answer 1" required>
                    </div>
                </div>

                <!-- Question 2 -->
                <div class="form-group row mt-3">
                    <div class="col-md-4">
                        <label for="q2" class="col-form-label">Question 2</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" id="q2" name="q2" class="form-control" value="" disabled>
                    </div>
                </div>
                <div class="form-group row mt-2">
                    <div class="offset-md-4 col-md-8">
                        <input type="text" name="q2_answer" class="form-control" placeholder="Answer 2" required>
                    </div>
                </div>

                <!-- Question 3 -->
                <div class="form-group row mt-3">
                    <div class="col-md-4">
                        <label for="q3" class="col-form-label">Question 3</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" id="q3" name="q3" class="form-control" value="" disabled>
                    </div>
                </div>
                <div class="form-group row mt-2">
                    <div class="offset-md-4 col-md-8">
                        <input type="text" name="q3_answer" class="form-control" placeholder="Answer 3" required>
                    </div>
                </div>
                <div class="form-group-full col-lg-6 offset-lg-6 d-flex justify-content-end align-items-end">
                    <button type="submit" class="btn_submit-primary">Verify</button>
                </div>
            </div>
        </form>
    </div>
</div>
