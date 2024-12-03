<!-- Modal for Create Deposit Record -->
<div id="resetpassword-modal" class="modal" style="padding-left: 250px; background-color: rgba(0, 0, 0, 0.725);">
    <div class="modal-content">
        <span class="close" onclick="closeResetPasswordModal()">&times;</span>
        <h1>Reset Password</h1>

        <form id="reset-password-form" onsubmit="resetPassword(event)">
            <div class="form-grid col-12">
                <div class="row row-no-gutters">
                  <div class="form-group row mt-2">
                        <div class="col-lg-4">
                            <label for="password" class="col-form-label">Password:</label>
                        </div>
                        <div class="col-lg-8">
                            <input type="password" id="reset-user-password" name="password" class="form-control" placeholder="Create password" required autocomplete="new-password">
                        </div>
                    </div>


                    <div class="form-group row mt-2">
                        <div class="col-lg-4">
                            <label for="confirm_password" class="col-form-label">Confirm Password:</label>
                        </div>
                        <div class="col-lg-8">
                            <input type="password" id="reset-user-confirm-password" name="confirm_password" class="form-control" placeholder="Confirm password" required autocomplete="new-password">
                        </div>
                    </div>

                <div class="row row-no-gutters">
                    <div class="form-group-full col-lg-12 d-flex justify-content-end align-items-end">
                        <button type="submit" class="btn_submit-primary">Change Password</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
