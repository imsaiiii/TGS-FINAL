
<?php session_start();include('connection.php');?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,, initial-scale=1.0" />

    <title>The Good Shots</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script>
        $(document).ready(function () {
            $('#supplierProductTable').DataTable();
        });
    </script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="dashboard.css" />

</head>

<body>
    <!--Add-->
    <!-- Add Product Modal -->
    <div class="modal fade" id="addUserData" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addProductForm" method="POST" action="code.php">
          <!-- Supplier Input -->
          <div class="mb-3">
            <label for="supplier" class="form-label">Supplier</label>
            <select class="form-select" id="supplier" name="supplier" required>
              <option value="">-- Select Category --</option>
              <?php
              // Connect to the database
              include('connection.php');

              // Retrieve categories from the database
              $stmt = $conn->prepare("SELECT supplier_name FROM suppliers");
              $stmt->execute();
              $result = $stmt->fetchAll();

              // Check if there are any categories
              if (count($result) > 0) {
                // Output the categories
                foreach ($result as $row) {
                  echo "<option value='" . htmlspecialchars($row['supplier_name']) . "'>" . htmlspecialchars($row['supplier_name']) . "</option>";
                }
              } else {
                echo "<option value=''>No categories found</option>";
              }

              // Close the database connection
              $conn = null;
              ?>
            </select>
          </div>

          <!-- Product Name Input -->
          <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" required>
          </div>

          <!-- Price Input -->
          <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
          </div>

          <!-- Measurement/Quantity Input -->
          <div class="mb-3">
            <label for="quantity" class="form-label">Measurement/Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" step="0.01" required>
          </div>

          <!-- Unit Input -->
          <div class="form-group">
            <label class="form-label">Unit</label>
            <select class="form-control" id="unit" name="unit" required>
              <option value="pack">pack</option>
              <option value="pieces">pieces</option>
              <option value="box">box</option>
              <option value="cups">cups</option>
            </select>
          </div>
          <!-- Reorder Level Input -->
          <div class="mb-3">
            <label for="reorder_level" class="form-label">Reorder Level</label>
            <input type="number" class="form-control" id="reorder_level" name="reorder_level" required>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="add_supp_product">Add Product</button>
          </div>
        </form>
      </div>
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
                    <h1 class="modal-title fs-2" id="editDataLabel">Edit Supplier</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="code.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="fs-5 mt-1 fw-bolder">Supplier Name</label>
                            <input type="text" class="form-control fw-medium" name="suppliername"
                                placeholder="Enter Supplier Name" required>
                        </div>
                        <div class="form-group">
                            <label class="fs-5 mt-1 fw-bolder">Contact Number</label>
                            <input type="text" class="form-control fw-medium" name="contactnumber"
                                placeholder="Enter Contact Number" required>
                        </div>
                        <div class="form-group">
                            <label class="fs-5 mt-1 fw-bolder">Status</label>
                            <select class="form-control fw-medium" id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <input type="hidden" name="id" id="id"> <!-- Hidden field for supplier ID -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn -secondary fw-medium"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="update_supplier" class="btn btn-primary fw-medium">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!---->
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
                <a href="purchase_order_admin.php" class="list-group-item">
                    <i class="fa-solid fa-money-bill me-3"></i>Purchase Order
                </a>
                <div class="supplier-dropdown">
                    <a href="#" class="list-group-item active" id="supplier-toggle">
                        <i class="fa-solid fa-boxes-packing me-3"></i>Supplier<i
                            class="fa-solid fa-chevron-right toggle-arrow-supplier" id="supplier-arrow"></i>
                    </a>
                    <div class="submenu" id="supplier-submenu">
                        <a href="addsupplier.php" class="sub-list-item">
                            <p class="txt-name-btn">Add Supplier</p>
                        </a>
                        <a href="addsupplier_product_admin.php" class="sub-list-item active">
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

            <div class="container-responsive mt-5">
                <div class="col-sm-12 col-lg-20">

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
                            <button type="button" class="btn btn-primary float-end fw-medium btn-add"
                                data-bs-toggle="modal" data-bs-target="#addUserData">
                                Add New Supplier
                            </button>
                        </div>
                        <div class="card-body mt-1">
                            <table id="supplierProductTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Supplier Name</th>
                                        <th scope="col">Product Number</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Reorder Level</th>
                                        <th scope="col" class="action-column">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $connection = mysqli_connect("localhost", "root", "", "tgs_inventory");

                                    $fetch_query = "SELECT * FROM supplier_products ";
                                    $fetch_query_run = mysqli_query($connection, $fetch_query);

                                    if (mysqli_num_rows($fetch_query_run) > 0) {
                                        while ($row = mysqli_fetch_array($fetch_query_run)) {

                                            ?>
                                            <tr>
                                                <td class="supplier_product_id"><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['supplier']; ?></td>
                                                <td><?php echo $row['product_name']; ?></td>
                                                <td><?php echo $row['price']; ?></td>
                                                <td><?php echo $row['quantity']; ?></td>
                                                <td><?php echo $row['unit']; ?></td>
                                                <td><?php echo $row['reorder_level']; ?></td>
                                              
                                                <td>
                                                    <a href="#" class="btn btn-info btn-base view_supplier_products">View
                                                        Data</a>
                                                    <a href="#" class="btn btn-success btn-base edit_supplier_products">Edit
                                                        Data</a>
                                                    <a href="" class="btn btn-danger btn-base delete_supplier_products">Delete
                                                        Data</a>
                                                </td>
                                            </tr>
                                            <?php

                                        }
                                    } else {
                                        ?>
                                        <tr colspan="5"> No Record Found </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>


        <script>
            $(document).ready(function () {
                $("#supplier-toggle").click(function (e) {
                    e.preventDefault();
                    $("#supplier-submenu").slideToggle();
                    const supplierArrow = $("#supplier-arrow");
                    if (supplierArrow.hasClass("fa-chevron-right")) {
                        supplierArrow.removeClass("fa-chevron-right").addClass("fa-chevron-down");
                    } else {
                        supplierArrow.removeClass("fa-chevron-down").addClass("fa-chevron-right");
                    }
                });

                $("#reports-toggle").click(function (e) {
                    e.preventDefault();
                    $("#reports-submenu").slideToggle();
                    const reportsArrow = $("#reports-arrow");
                    if (reportsArrow.hasClass("fa-chevron-right")) {
                        reportsArrow.removeClass("fa-chevron-right").addClass("fa-chevron-down");
                    } else {
                        reportsArrow.removeClass("fa-chevron-down").addClass("fa-chevron-right");
                    }
                });
            });
        </script>
</body>

</html>

<?php include('function/viewdata.js'); ?>
<?php include('function/editdata.js'); ?>
<?php include('function/remove.js'); ?>