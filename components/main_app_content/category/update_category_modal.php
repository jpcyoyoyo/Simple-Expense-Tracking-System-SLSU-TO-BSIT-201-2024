<!-- Modal for Create Deposit Record -->
<div id="edit-category-modal" class="modal" style="padding-left: 250px; background-color: rgba(0, 0, 0, 0.725);">
    <div class="modal-content">
        <span class="close" onclick="closeEditCategoryModal()">&times;</span>
        <h1>Edit Category</h1>

        <form id="update-category-form" onsubmit="updateCategory(event)">
        <input type="hidden" id="category-id">
        <input type="hidden" id="old-category-name">
            <div class="form-grid col-12">
                <div class="row row-no-gutters">
                    <label for="renaming-category-warning">If you rename the category name, it will update the category name to your deposit and expense records.</label>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="description">Name</label>
                        <input type="text" id="edit_category_name" class="form-control" placeholder="Enter categoty name" required />
                    </div>

                    <!-- Date in the second column -->
                    <div class="form-group col-lg-6">
                        <label for="description">Description</label>
                        <input type="text" id="edit_category_description" class="form-control" placeholder="Enter description" required />
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group-full col-lg-12 d-flex justify-content-end align-items-end">
                        <button type="submit" class="btn_submit-primary">Edit Category</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

</div>

