<!-- Modal for Create Deposit Record -->
<div id="category-modal" class="modal" style="padding-left: 250px; background-color: rgba(0, 0, 0, 0.725);">
    <div class="modal-content">
        <span class="close" onclick="closeCategoryModal()">&times;</span>
        <h1>Create Category</h1>

        <form id="create-category-form" onsubmit="addCategoryRecord(event)">
            <div class="form-grid col-12">
                <di class="row row-no-gutters">
                    <div class="form-group col-lg-6">
                        <label for="description">Name</label>
                        <input type="text" id="create_category_name" class="form-control" placeholder="Enter category name" required />
                    </div>

                    <!-- Date in the second column -->
                    <div class="form-group col-lg-6">
                        <label for="description">Description</label>
                        <input type="text" id="create_category_description" class="form-control" placeholder="Enter description" required />
                    </div>
                </div>

                <div class="row row-no-gutters">
                    <div class="form-group-full col-lg-12 d-flex justify-content-end align-items-end">
                        <button type="submit" class="btn_submit-primary">Add Caterogy</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>