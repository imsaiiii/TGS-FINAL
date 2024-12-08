<?php session_start();include('connection.php');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=1024, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">

    <script src = "https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src = "https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src = "https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

    <script>
      $(document).ready(function(){
    $('#user-management').DataTable();
    });
    </script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="dashboard.css" />
    <title>The Good Shots</title>
</head>

<!--Add User-->
<div class="modal fade" id="addUserData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="addUserDataLabel" aria-hidden="true">
  
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-2" id="addUserDataLabel">Adding New Item</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="code.php" method="POST" onsubmit="return validateForm()">
        <div class="modal-body">

          <div class="form-group">
            <label for="supplier"><b>Supplier</b></label>
            <select class="form-control" id="supplier" name="supplier" required onchange="loadProducts()">
              <option value="">-- Select Supplier --</option>
              <?php
              include('connection.php');
              $stmt = $conn->prepare("SELECT supplier_name FROM suppliers");
              $stmt->execute();
              $result = $stmt->fetchAll();

              if (count($result) > 0) {
                foreach ($result as $row) {
                  echo "<option value='" . $row['supplier_name'] . "'>" . $row['supplier_name'] . "</option>";
                }
              } else {
                echo "<option value=''>No suppliers found</option>";
              }
              $conn = null;
              ?>
            </select>
          </div>

          <div class="form-group">
            <label for="product"><b>Product</b></label>
            <select class="form-control" id="product" name="product_name" required>
              <option value="">-- Select Product --</option>
            </select>
          </div>

          <script>
            function loadProducts() {
              var supplier = document.getElementById("supplier").value;
              var xhr = new XMLHttpRequest();
              xhr.open("GET", "fetch_products.php?supplier=" + supplier, true);
              xhr.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                  document.getElementById("product").innerHTML = this.responseText;
                }
              };
              xhr.send();
            }
          </script>

          <div class="form-group">
            <label class="fs-5 mt-1 fw-bolder">Package Quantity</label>
            <input type="number" class="form-control fw-medium" id="package_quantity" name="package_quantity"
              placeholder="Enter quantity" step="0.01" oninput="calculateTotal()" required>
          </div>

          <div class="form-group">
            <label class="fs-5 mt-1 fw-bolder">Measurement per Pack</label>
            <input type="number" class="form-control fw-medium" id="measurement_per_package"
              name="measurement_per_package" placeholder="Enter Measurement" step="0.01" oninput="calculateTotal()" required>
          </div>

          <div class="form-group">
            <label class="fs-5 mt-1 fw-bolder">Total Measurement</label>
            <input type="number" class="form-control fw-medium" id="total_measurement" name="total_measurement"
              placeholder="Enter Total" step="0.01" readonly required>
          </div>

          <script>
            function calculateTotal() {
              const packageQuantity = parseFloat(document.getElementById('package_quantity').value) || 0;
              const measurementPerPackage = parseFloat(document.getElementById('measurement_per_package').value) || 0;
              const totalMeasurement = packageQuantity * measurementPerPackage;

              document.getElementById('total_measurement').value = totalMeasurement.toFixed(2);
            }

            function validateForm() {
              const fields = ['supplier', 'product', 'package_quantity', 'measurement_per_package', 'total_measurement', 'unit', 'Expiry_Date'];
              for (const id of fields) {
                const element = document.getElementById(id);
                if (!element.value) {
                  alert(`Please fill out the ${element.name || id} field.`);
                  element.focus();
                  return false;
                }
              }
              return true;
            }
          </script>

          <div class="form-group">
            <label class="fs-5 mt-1 fw-bolder">Unit</label>
            <select class="form-control fw-medium" id="unit" name="unit" required>
              <option value="milliliter">milliliter </option>
              <option value="grams">grams</option>
            </select>
          </div>

          

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary fw-medium" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="add_inventory" class="btn btn-primary fw-medium">Add Item</button>
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

      <!-- Main Form for Add User -->
      <form action="code.php" method="POST">
        <div class="form-group">
          <label for="supplier"><b>Supplier</b></label>
          <select class="form-control" id="supplier" name="supplier" required onchange="loadProducts()">
            <option value="">-- Select Supplier --</option>
            <?php
            include('connection.php');
            $stmt = $conn->prepare("SELECT supplier_name FROM suppliers");
            $stmt->execute();
            $result = $stmt->fetchAll();

            if (count($result) > 0) {
              foreach ($result as $row) {
                echo "<option value='" . $row['supplier_name'] . "'>" . $row['supplier_name'] . "</option>";
              }
            } else {
              echo "<option value=''>No suppliers found</option>";
            }
            $conn = null;
            ?>
          </select>
        </div>

        <div class="form-group">
          <label for="product"><b>Product</b></label>
          <select class="form-control" id="product" name="product" required>
            <option value="">-- Select Product --</option>
          </select>
        </div>

        <script>
          function loadProducts() {
            var supplier = document.getElementById("supplier").value;

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "fetch_products.php?supplier=" + supplier, true);
            xhr.onreadystatechange = function () {
              if (this.readyState == 4 && this.status == 200) {
                document.getElementById("product").innerHTML = this.responseText;
              }
            };
            xhr.send();
          }
        </script>

        <div class="form-group">
          <label class="fs-5 mt-1 fw-bolder">Package Quantity</label>
          <input type="number" class="form-control fw-medium" id="package_quantity" name="package_quantity"
            placeholder="Enter quantity" step="0.01" oninput="calculateTotal()">
        </div>

        <div class="form-group">
          <label class="fs-5 mt-1 fw-bolder">Measurement per Pack</label>
          <input type="number" class="form-control fw-medium" id="measurement_per_package"
            name="measurement_per_package" placeholder="Enter Measurement" step="0.01" oninput="calculateTotal()">
        </div>

        <div class="form-group">
          <label class="fs-5 mt-1 fw-bolder">Total Measurement</label>
          <input type="number" class="form-control fw-medium" id="total_measurement" name="total_measurement"
            placeholder="Enter Total" step="0.01" readonly>
        </div>

        <script>
          function calculateTotal() {
            const packageQuantity = parseFloat(document.getElementById('package_quantity').value) || 0;
            const measurementPerPackage = parseFloat(document.getElementById('measurement_per_package').value) || 0;
            const totalMeasurement = packageQuantity * measurementPerPackage;

            document.getElementById('total_measurement').value = totalMeasurement.toFixed(2);
          }
        </script>

        <div class="form-group">
          <label class="fs-5 mt-1 fw-bolder">Unit</label>
          <select class="form-control fw-medium" id="unit" name="unit">
            <option value="milliliter">milliliter </option>
            <option value="grams">grams</option>
          </select>
        </div>

        <div class="form-group">
          <label class="fs-5 mt-1 fw-bolder">Expiration Date</label>
          <input type="date" class="form-control fw-medium" name="Expiry_Date" placeholder="Enter Expiry Date">
        </div>

       

      <!-- Form for Update Item (Separate Action if Needed) -->
      <form action="update_code.php" method="POST">
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary fw-medium" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="update_inventory" class="btn btn-primary fw-medium">Update Item</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!---->
<div class="d-flex content">
    <div id="sidebar" class="sidebar-color">
      <div class="sidebar-heading">
        <img src="images/Logo.jpg" alt="Bootstrap" class="logo">The Good Shots
      </div>
      <div class="list-group list-group-flush mt-0">
        <a href="index.php" class="list-group-item">
          <i class="fas fa-tachometer-alt me-3"></i>Dashboard
        </a>
        <a href="adduser.php" class="list-group-item">
          <i class="fas fa-project-diagram me-3"></i>User Management
        </a>
        <a href="addproduct.php" class="list-group-item">
          <i class="fa-brands fa-product-hunt me-3"></i>Product Management
        </a>
        <a href="inventoryManage.php" class="list-group-item active">
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
          <h2 class="fs-3 m-1">Inventory Management</h2>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-1 mb-lg-0">
            <a class="nav-link fw-bold cashier-link me-3 text-dark" href="pos.php">
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
                                <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin'; ?>
                            </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>

    <div class="container-responsive ms-2">
        <div class="col-lg-12">

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
           <div class="card shadow mt-5">
            <div class="card-header">
              <button type="button" class="btn btn-primary float-end fw-medium btn-add" data-bs-toggle="modal"
                data-bs-target="#addUserData">
                Add New User
              </button>
            </div>
            <div class="card-body">
              <table id="user-management" class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Supplier</th>
                      <th scope="col">Product Name</th>
                      <th scope="col">Package Quantity</th>
                      <th scope="col">Measurement Per Package</th>
                      <th scope="col">Total Measurement</th>              
                      <th scope="col">Unit</th>
                        
                      <th scope="col" class = "action-column">Action</th>
                  </tr>
                </thead>
                  <tbody>
                 <?php
include 'connection.php'; // Ensure this file sets up the PDO connection

// Create a new PDO instance

// Prepare and execute the fetch query
$fetch_query = "SELECT * FROM inventory";
$stmt = $conn->prepare($fetch_query);
$stmt->execute();

// Check if there are results
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['supplier']); ?></td>
            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
            <td><?php echo htmlspecialchars($row['package_quantity']); ?></td>
            <td><?php echo htmlspecialchars($row['measurement_per_package']); ?></td>
            <td><?php echo htmlspecialchars($row['total_measurement']); ?></td>
            <td><?php echo htmlspecialchars($row['unit']); ?></td>
            <td>
                <a href="#" class="btn btn-info btn-base view_data btn-view" data-id="<?php echo $row['id']; ?>">View</a>
                <a href="#" class="btn btn-success btn-base edit_data btn-edit" data-id="<?php echo $row['id']; ?>">Edit</a>
                <a href="#" class="btn btn-danger btn-base delete_user btn-delete" data-id="<?php echo $row['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php
    }
} else {
    echo "<tr><td colspan='8' class='text-center'>No record found</td></tr>";
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
                $("#product-toggle").click(function (e) {
                e.preventDefault();
                $("#product-submenu").slideToggle();
                const productArrow = $("#product-arrow");
                if (productArrow.hasClass("fa-chevron-right")) {
                    productArrow.removeClass("fa-chevron-right").addClass("fa-chevron-down");
                } else {
                    productArrow.removeClass("fa-chevron-down").addClass("fa-chevron-right");
                }
            });

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
