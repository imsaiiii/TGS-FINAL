<!doctype html>
< lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>The Good Shots</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="dashboard.css" />
</head>

<body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
<?php 
include('add.php');
?>
  <!-- Add Product Modal -->
  <div class="modal fade" id="insertdata" tabindex="-1" aria-labelledby="insertdataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insertdataLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registration-form" method="POST" action="code.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="productname" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productname" name="productname" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept=".jpg, .jpeg, .png" onchange="previewImage(event)">
                        <img id="imagePreview" src="" alt="Image Preview" style="max-width: 300px; display: none;">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">-- Select Category --</option>
                            <!-- Populate categories dynamically -->
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="add_product">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

  <script>
    function previewImage(event) {
      var reader = new FileReader();
      reader.onload = function () {
        var output = document.getElementById('imagePreview');
        output.src = reader.result;
        output.style.display = 'block';
      };
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>

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
                    <a href="addproduct_admin.php" class="list-group-item active" id="product-toggle">
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
                    <a href="#" class="list-group-item" id="supplier-toggle">
                        <i class="fa-solid fa-boxes-packing me-3"></i>Supplier<i
                            class="fa-solid fa-chevron-right toggle-arrow-supplier" id="supplier-arrow"></i>
                    </a>
                    <div class="submenu" id="supplier-submenu">
                        <a href="addsupplier_admin.php" class="sub-list-item">
                            <p class="txt-name-btn">Add Supplier</p>
                        </a>
                        <a href="addsupplier_product_admin.php" class="sub-list-item">
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

      <div class="container responsive" style="margin-top: 60px">
        <div class="row justify-content-center">
          <div class="col-lg-20">
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
            <div class="card">
              <div class="card-header">
                <h3 class="text-center">Product Management</h3>
                <button type="button" class="btn btn-primary float-end fw-medium" data-bs-toggle="modal"
                  data-bs-target="#insertdata">
                  Add New Product
                </button>
              </div>
              <div class="card-body mt-1">
                <table id="product" class="table table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Product Name</th>
                      <th scope="col">Price</th>
                      <th scope="col">Category</th>
                      
                       <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $connection = mysqli_connect("localhost", "root", "", "tgs_inventory");
                    if (!$connection) {
                      die('Database connection failed: ' . mysqli_connect_error());
                    }

                    $fetch_query = "SELECT * FROM products";
                    $fetch_query_run = mysqli_query($connection, $fetch_query);
                    if (!$fetch_query_run) {
                      die('Query Failed: ' . mysqli_error($connection));
                    }

                    if (mysqli_num_rows($fetch_query_run) > 0) {
                      while ($row = mysqli_fetch_array($fetch_query_run)) {
                        ?>
                        <tr>
                          <td class="product_id"><?php echo $row['id']; ?></td>
                          <td><?php echo $row['product_name']; ?></td>
                          <td><?php echo $row['price']; ?></td>
                          <td><?php echo $row['category']; ?></td>
                          
                          <td>
                            <a href="#" class="btn btn-info btn-base view_product">View Data</a>
                            <a href="#" class="btn btn-success btn-base edit_product">Edit Data</a>
                            <a href="#" class="btn btn-danger btn-base delete_product">Delete Data</a>
                          </td>
                        </tr>
                        <?php
                      }
                    } else {
                      ?>
                      <tr>
                        <td colspan="6" class="text-center">No Record Found</td>
                      </tr>
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

      <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
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
    </div>
  </div>
</body>

</html>
<?php include('function/viewdata.js'); ?>
<?php include('function/editdata.js'); ?>
<?php include('function/remove.js'); ?>