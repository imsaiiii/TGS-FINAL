<?php
session_start();
include('header.php'); ?>

<style>
 .product-submenu{
    display: block;
    padding-left: 10px;
}
.product-submenu.active {
    display: block;
}
</style>

<!--Add-->
<!--Add User-->
<div class="modal fade" id="addUserData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addUserDataLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-2" id="addUser DataLabel">Adding New Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="code.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="fs-5 mt-1 fw-bolder">Category Name</label>
                        <input type="text" class="form-control fw-medium" name="name"
                            placeholder="Enter Category Name">
                    </div>
                    <div class="form-group">
                        <label class="fs-5 mt-1 fw-bolder">Description</label>
                        <input type="text" class="form-control fw-medium" name="description"
                            placeholder="Enter Enter Description">
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary fw-medium" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_category" class="btn btn-primary fw-medium">Add Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!---->
<!--view-->
<div class="modal fade" id="viewitemModal" tabindex="-1" aria-labelledby="viewitemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="viewitemModalLabel">View Item</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="view_item_data">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
<!---->
<!--edit-->
<div class="modal fade" id="editData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="editDataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-2" id="editDataLabel">Edit Users</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="code.php" method="POST">
                <div class="modal-body">

                    <div class="form-group">
                        <input type="hidden" class="form-control fw-medium" id="id" name="id">
                    </div>
                    <div class="form-group">
                        <label class="fs-5 mt-1 fw-bolder">Category Name</label>
                        <input type="text" class="form-control fw-medium" name="name"
                            placeholder="Enter First Name">
                    </div>
                    <div class="form-group">
                        <label class="fs-5 mt-1 fw-bolder">Description</label>
                        <input type="text" class="form-control fw-medium" name="description" placeholder="Enter Last Name">
                    </div>
                   


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary fw-medium" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="update_category" class="btn btn-primary fw-medium">Update Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="d-flex content">
    <div id="sidebar" class="sidebar-color">
      <div class="sidebar-heading">
        <img src="Images/Logo.jpg" class="logo">The Good Shots
      </div>
      <div class="list-group list-group-flush mt-0">
        <a href="dashboard.php" class="list-group-item">
          <i class="fas fa-tachometer-alt me-3"></i>Dashboard
        </a>
        <a href="adduser.php" class="list-group-item">
          <i class="fas fa-project-diagram me-3"></i>User Management
        </a>
        <div class="product-dropdown">
          <a href="#" class="list-group-item active" id="product-toggle">
            <i class="fa-brands fa-product-hunt me-3"></i></i>Product Management<i
              class="fa-solid fa-chevron-right toggle-arrow-product" id="product-arrow"></i>
          </a>
          <div class="submenu" id="product-submenu">
            <a href="addproduct.php" class="sub-list-item">
              <p class="txt-name-btn">Add Product</p>
            </a>
            <a href="addcategory.php" class="sub-list-item active">
              <p class="txt-name-btn">Add Category</p>
            </a>
          </div>
        </div>
        <a href="inventoryManage.php" class="list-group-item">
          <i class="fas fa-shopping-cart me-3"></i>Inventory Management
        </a>
        <a href="purchase_order.php" class="list-group-item">
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
            <a href="discrepancy.php" class="sub-list-item">
              <p class="txt-name-btn">Supplier Report</p>
            </a>
            <a href="inventoryReport.php" class="sub-list-item">
              <p class="txt-name-btn">List of Products Report</p>
            </a>
            <a href="salesReport.php" class="sub-list-item">
              <p class="txt-name-btn">Sales Report</p>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div id="page-content-wrapper">
      <nav class="navbar navbar-expand-lg navbar-light bg-transparent px-4 mt-2 dashboard-nav">
        <div class="d-flex align-items-center">
          <h2 class="fs-3 m-1">Product Management</h2>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-1 mb-lg-0">
            <a class="nav-link fw-bold cashier-link" href="order.php"
              style="color: black; font-weight: 200; font-size: 17px;">
              <i class="fa-solid fa-cash-register me-2"></i>
              Food & Orders
            </a>
            <a class="nav-link fw-bold notification-link" href="#"
              style="color: black; font-weight: 200; font-size: 17px;">
              <i class="fa-solid fa-bell me-2"></i>
              Notification
            </a>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle fw-bold admin-link" href="#"
                style="color: black; font-weight: 200; font-size: 17px;" id="navbarDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-regular fa-circle-user me-2" style="font-size: 25px"></i>
                Admin
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>

      <div class="container-responsive" style="margin-top: 40px; padding: 25px;">
        <div class="col-sm-12">

          <?php
          if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
            ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <?php echo $_SESSION['status']; ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
              const alert = document.querySelector('.alert');
              setTimeout(() => {
                alert.style.display = 'none';
              }, 3000);
            </script>
            <?php
            unset($_SESSION['status']);
          }

          ?>
          <div class="card shadow">
            <div class="card-header">
              <h3 class="text-center">Add Category</h3>
              <button type="button" class="btn btn-primary float-end fw-medium btn-add" data-bs-toggle="modal"
                data-bs-target="#addUserData">
                Add New User
              </button>
            </div>
            <div class="card-body mt-1">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Supplier</th>
                    <th scope="col">Product</th>
                    <th scope="col">Package Quantity</th>
                    <th scope="col">Measurement Per Package</th>
                    <th scope="col">Total_measurement</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Expiration Date</th>
                    <th scope="col"></th>
                  </tr>
                </thead>

                <tbody>
                
                </tbody>
              </table>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  
<?php include('footer.php'); ?>
<?php include('function/viewdata.js'); ?>
<?php include('function/editdata.js'); ?>
<?php include('function/remove.js'); ?>