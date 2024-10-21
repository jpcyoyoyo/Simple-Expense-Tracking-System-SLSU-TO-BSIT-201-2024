
<div class="col-md-9 offset-md-3 col-12 main-app-content content">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Expenses</h2>
        <a href="create_expense.html" class="btn btn-create">+ Create Expense Record</a>

    </div>

    <div class="mt-3 mb-4">
        <input type="text" class="form-control" placeholder="Search Transaction / Date">
    </div>

    <div class="d-flex mb-3">
        <button class="btn btn-outline-info me-2">All 50</button>
        <button class="btn btn-outline-info">Month</button>
    </div>

    <div class="mb-3">
        <h6>MONTH: <span class="badge bg-light text-dark">January 2024</span></h6>
    </div>
    
    <!-- Dropdown for months -->
    <div class="dropdown">
        <button class="btn btn-dropdown dropdown-toggle" type="button" id="menu1" data-bs-toggle="dropdown" aria-expanded="false">
            Select Month
        </button>
        <ul class="dropdown-menu" aria-labelledby="menu1">
            <li><a class="dropdown-item" href="#">FEBRUARY</a></li>
            <li><a class="dropdown-item" href="#">MARCH</a></li>
            <li><a class="dropdown-item" href="#">APRIL</a></li>
            <li><a class="dropdown-item" href="#">MAY</a></li>
            <li><a class="dropdown-item" href="#">JUNE</a></li>
            <li><a class="dropdown-item" href="#">JULY</a></li>
            <li><a class="dropdown-item" href="#">AUGUST</a></li>
            <li><a class="dropdown-item" href="#">SEPTEMBER</a></li>
            <li><a class="dropdown-item" href="#">OCTOBER</a></li>
            <li><a class="dropdown-item" href="#">NOVEMBER</a></li>
            <li><a class="dropdown-item" href="#">DECEMBER</a></li>
        </ul>
    </div>

    <!-- Scrollable Table -->
    <div class="table-wrapper">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Date</th>
                    <th>Categories</th>
                    <th>Items</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1.</td>
                    <td>1-01-2024</td>
                    <td>Foods</td>
                    <td>Snacks, Beverages, Groceries</td>
                    <td>$$$.$$</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary">✏️ Edit</button>
                        <button class="btn btn-sm btn-outline-danger">🗑️ Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>1-10-2024</td>
                    <td>Transportation</td>
                    <td>Car payments, Fuel costs</td>
                    <td>$$$.$$</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary">✏️ Edit</button>
                        <button class="btn btn-sm btn-outline-danger">🗑️ Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>1-20-2024</td>
                    <td>Supplies and Materials</td>
                    <td>Office supplies, Event materials, Equipment rentals</td>
                    <td>$$$.$$</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary">✏️ Edit</button>
                        <button class="btn btn-sm btn-outline-danger">🗑️ Delete</button>
                    </td>
                </tr>
                <!-- Additional rows can go here -->
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

