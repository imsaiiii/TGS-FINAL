<?php
session_start();
include('header.php');
include('connection.php'); // Ensure connection is included at the beginning


?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="function/po_database.js"> </script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="po_database.js"></script> <!-- Include your JavaScript file -->

<!-- Purchase Order Modal -->
<div class="modal fade" id="purchaseOrderModal" tabindex="-1" role="dialog" aria-labelledby="purchaseOrderLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="purchaseOrderLabel">Purchase Order Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Purchase Order Date and Time: <span id="transactionDate"><?php echo date("Y-m-d h:i:sa"); ?></span></p>
        <p>Purchase Order Number: <span id="transactionNumber"></span></p>
        <hr>

        <!-- Supplier Selection -->
        <div class="form-group">
          <label for="supplier"><b>Supplier</b></label>
          <select class="form-control" id="supplier" name="supplier" required onchange="loadProducts()">
            <option value="">-- Select Supplier --</option>
            <?php
            // Sample PHP code to fetch suppliers
            // Replace with your actual database connection and query
            $suppliers = $conn->query("SELECT supplier_name FROM suppliers")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($suppliers as $row) {
              echo '<option value="' . htmlspecialchars($row['supplier_name']) . '">' . htmlspecialchars($row['supplier_name']) . '</option>';
            }
            ?>
          </select>
        </div>

        <hr>
        <div class="form-group">
          <label for="product"><b>Product:</b></label>
          <select class="form-control" id="product_list" name="product" required>
            <option value="">-- Select Product --</option>
          </select>
        </div>

        <!-- Quantity Input -->
        <div class="form-group">
          <label for="product_qty"><b>Quantity:</b></label>
          <input type="number" id="product_qty" name="product_qty" class="form-control" min="1">
          <button id="btn_add" class="btn btn-primary mt-2" onclick="addProduct()">Add Product</button>
        </div>

        <!-- Product Table -->
        <table id="display" class="table table-bordered mt-4">
          <thead>
            <tr>
              <th>Product</th>
              <th>Unit Price</th>
              <th>Quantity</th>
              <th>Amount</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>

        <!-- Total Price -->
        <div class="d-flex justify-content-between">
          <strong>Total:</strong>
          <span id="total_price">0.00</span>
        </div>
      </div>

      <!-- Footer Buttons -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="showPopupForm()">Continue</button>
      </div>
    </div>
  </div>
</div>

<!-- Confirmation Modal -->
<div id="popupForm" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Purchase</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <label for="totalPriceInput">Total Amount:</label>
          <input type="text" class="form-control" id="totalPriceInput" readonly>
          <div class="mt-3">
            <button type="button" class="btn btn-primary" onclick="saveTransaction()">Confirm</button>
            <button type="button" class="btn btn-secondary fw-medium" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<body>
    <div class="d-flex content">
        <div id="sidebar" class="sidebar-color">
            <div class="sidebar-heading">
                <img src="Images/Logo.jpg" alt="Bootstrap" class="logo">The Good Shots
            </div>
            <div class="list-group list-group-flush mt-0">
                <a href="dashboard_admin.php" class="list-group-item">
                    <i class="fas fa-tachometer-alt me-3"></i>Dashboard
                </a>
                <div class="product-dropdown">
                    <a href="addproduct_admin.php" class="list-group-item" id="product-toggle">
                        <i class="fa-brands fa-product-hunt me-3"></i>Product Management
                    </a>
                </div>
                <a href="inventoryManage_admin.php" class="list-group-item">
                    <i class="fas fa-shopping-cart me-3"></i>Inventory Management
                </a>
                <a href="purchase_order_admin.php" class="list-group-item active">
                    <i class="fa-solid fa-money-bill me-3"></i>Purchase Order
                </a>
                <div class="supplier-dropdown">
                    <a href="#" class="list-group-item" id="supplier-toggle">
                        <i class="fa-solid fa-boxes-packing me-3"></i>Supplier<i
                            class="fa-solid fa-chevron-right toggle-arrow-supplier" id="supplier-arrow"></i>
                    </a>
                    <div class="submenu" id="supplier-submenu">
                        <a href="addsupplier.php" class="sub-list-item">
                            <p class="txt-name-btn">Add Supplier</p>
                        </a>
                        <a href="addsupplier_product.php" class="sub-list-item">
                            <p class="txt-name-btn">Suppliers Product</p>
                        </a>
                    </div>
                </div>
                <div class="reports-dropdown">
                    <a href="#" class="list-group-item" id="reports-toggle">
                        <i class="fa-solid fa-calendar-days me-3"></i></i>Reports<i
                            class="fa-solid fa-chevron-right toggle-arrow-reports" id="reports-arrow"></i>
                    </a>
                    <div class="submenu" id="reports-submenu">
                        <a href="discrepancy_admin.php" class="sub-list-item">
                            <p class="txt-name-btn">Discrepancy Report</p>
                        </a>
                        <a href="inventoryReport_admin.php" class="sub-list-item">
                            <p class="txt-name-btn">Inventory Report</p>
                        </a>
                        <a href="salesReport_admin.php" class="sub-list-item">
                            <p class="txt-name-btn">Sales Report</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent px-3 mt-2 dashboard-nav">
                <div class="d-flex align-items-center">
                    <h2 class="fs-3 m-1">Dashboard</h2>
                </div>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-1 mb-lg-0">
                        <a class="nav-link fw-bold cashier-link me-3 text-dark" href="order.php">
                            <img src="icons/cashier-svgrepo-com.svg" alt="" class="topnavbar-icons">
                            Orders
                        </a>
                        <a class="nav-link fw-bold notification-link me-3 text-dark" href="#">
                            <img src="icons/notifications-alert-svgrepo-com.svg" alt="" class="topnavbar-icons">
                            Notifications
                        </a>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold notification-link text-dark" href="#"
                                id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="icons/profile-round-1342-svgrepo-com.svg" alt="" class="user-icons">
                                Admin
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
    <div class="container-responsive" style="margin-top: 40px; padding: 25px">
      <div class="row justify-content-center">
        <div class="col-sm-12 col-lg-20">

          <?php if (isset($_SESSION['status']) && $_SESSION['status'] != ''): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <?php echo $_SESSION['status']; ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
              const alert = document.querySelector('.alert');

              setTimeout(() => {
                alert.style.display = 'none';
              },  3000);
            </script>
            <?php unset($_SESSION['status']); ?>
          <?php endif; ?>

          <div class="card">
            <div class="card-header">
              <h3 class="text-center">Purchase Order</h3>
              <button type="button" class="btn btn-primary float-end fw-medium" data-toggle="modal" data-target="#purchaseOrderModal">
                Add New Order
              </button>
            </div>
            <table id="myTable" class="table table-striped table-bordered table-secondary">
              <thead>
                <tr>
                  <th scope="col">PO ID</th>
                  <th scope="col">Quantity Ordered</th>
                  <th scope="col">Quantity Received</th>
                  <th scope="col">Supplier</th>
                  <th scope="col">PO Date</th>
                  <th scope="col">Status</th>
                  <th scope="col" class="tbl-action">Action</th>
                </tr>
              </thead>
              <tbody>
               
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

