<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>The Good Shots</title>



  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <link rel="stylesheet" href="dashboard.css" />
 
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Custom CSS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



  <link rel="stylesheet" href="dashboard.css" />

  <script src="function/po_database.js"> </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="dashboard.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <script src="function/po_database.js"> </script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    });
  </script>
</head>

<body>
  <?php
  session_start();
  include('connection.php');
  $qty_received = isset($_POST['qty_received']) ? $_POST['qty_received'] : null;

  ?>
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


          <div class="form-group">
            <label for="supplier"><b>Supplier</b></label>
            <select class="form-control" id="supplier" name="supplier" required onchange="loadProducts()">
              <option value="">-- Select Supplier --</option>
              <?php
              try {

                include 'connection.php';


                $stmt = $conn->query("SELECT supplier_name FROM suppliers");
                $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);


                foreach ($suppliers as $row) {
                  echo '<option value="' . htmlspecialchars($row['supplier_name']) . '">' . htmlspecialchars($row['supplier_name']) . '</option>';
                }
              } catch (PDOException $e) {

                echo 'Error: ' . htmlspecialchars($e->getMessage());
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
          <table id="display" class="table table-striped">
            <thead>
              <tr>
                <th>Product</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Supplier</th>
                <th>Amount</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>


          <div class="d-flex justify-content-between">
            <strong>Total:</strong>
            <span id="total_price">0.00</span>
          </div>
        </div>


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

  <!-- Modal HTML (Bootstrap modal) -->
<div class="modal fade" id="editdata" tabindex="-1" aria-labelledby="editdataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editdataLabel">EDIT DATA</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form for editing -->
            <form id="updateForm" action="po_actions.php" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- PO ID, Product Name, and Quantity Ordered are read-only -->
                            <div class="form-group mb-3">
                                <label for="po_id">PO ID</label>
                                <input type="text" class="form-control" id="po_id" name="po_id" readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label for="product_name">Product Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label for="quantity">Qty Ordered</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="qty_received">Qty Received</label>
                                <input type="number" class="form-control" id="qty_received" name="qty_received" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="supplier_name">Supplier</label>
                                <input type="text" class="form-control" id="supplier_name" name="supplier_name" readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <input type="text" class="form-control" name="status" id="status">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="update_data" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>



        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="update_data" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
  </div>
  <div id="view_items" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body view_item">
                <!-- Dynamic content will be injected here -->
            </div>
        </div>
    </div>
</div>


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
        <a href="inventoryManage.php" class="list-group-item">
          <i class="fas fa-shopping-cart me-3"></i>Inventory Management
        </a>
        <a href="purchase_order.php" class="list-group-item active">
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
          <h2 class="fs-3 m-1">Purchase Order</h2>
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
              <a class="nav-link dropdown-toggle fw-bold notification-link text-dark" href="#" id="navbarDropdown"
                role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                }, 3000);
              </script>
              <?php unset($_SESSION['status']); ?>
            <?php endif; ?>

            <div class="card shadow">
              <div class="card-header">
                <button type="button" class="btn btn-primary float-end fw-medium" data-toggle="modal"
                  data-target="#purchaseOrderModal">
                  Add New Order
                </button>
              </div>
              <table id="myTable" class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col" hidden>Product ID</th>
                    <th scope="col">PO Number</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Qty Ordered</th>
                    <th scope="col">Qty Received</th>
                    <th scope="col">Supplier</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ordered By</th>
                    <th scope="col" style="width: 25rem">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = "SELECT po.id, po.po_number, po.created_at, po.qty_received, pod.quantity, pod.product_name, pod.unit_price, pod.supplier_name, pod.status
                  FROM purchase_orders po
                  LEFT JOIN purchase_order_details pod ON po.id = pod.po_id";

                  $query_run = $conn->query($query);
                  if ($query_run && $query_run->rowCount() > 0) {
                    foreach ($query_run as $row) {
                      $status = isset($row['status']) ? $row['status'] : 'pending';
                      $disableEdit = $status === 'complete' ? 'disabled' : '';
                      $rowColorClass = '';

                      switch ($status) {
                        case 'complete':
                          $rowColorClass = 'table-success';
                          break;
                        case 'incomplete':
                          $rowColorClass = 'table-incomplete';
                          break;
                        case 'pending':
                          $rowColorClass = 'table-pending';
                          break;
                        default:
                          $rowColorClass = '';
                      }
                      ?>

                      <tr class="<?php echo $rowColorClass; ?>">
                        <td hidden class="order_id"><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['po_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($row['qty_received']); ?></td>
                        <td><?php echo htmlspecialchars($row['supplier_name']); ?></td>
                        <td><?php echo htmlspecialchars($status); ?></td>
                        <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($row['created_at']))); ?></td>
                        <td>
                          <div class="modal-footer d-flex justify-content-end">
                            <button class="btn btn-info btn-sm view_data" data-bs-toggle="modal"
                              data-bs-target="#view_items">View</button>
                            <button class="btn btn-success btn-sm edit_data" data-bs-toggle="modal"
                              data-bs-target="#editData" data-id="<?php echo htmlspecialchars($row['id']); ?>" <?php echo $disableEdit; ?>>Edit</button>
                          </div>
                        </td>
                      </tr>
                      <?php
                    }
                  } else {
                    echo "<tr><td colspan='9'>No Records Found</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
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
$(document).ready(function () {
  
    $(document).on('click', '.view_data', function(e){
  e.preventDefault();

  console.log("View button clicked");

  var order_id = $(this).closest('tr').children('td:first').text();
  console.log("User ID:", order_id);

  $.ajax({
    method: "POST",
    url: "po_actions.php",
    data: {
      'click__view_data_btn': true,
      'order_id': order_id,
    },
    success: function(response){
      console.log("AJAX success:", response);
      $('.view_item').html(response);
      $('#view_items').modal('show');
    },
    error: function(xhr, status, error) {
      console.error("AJAX error:", error);
    }
  });
  });
  
});


$(document).ready(function () {

// Handle the "Edit" button click
$(document).on('click', '.edit_data', function(e) {
  e.preventDefault();

  var order_id = $(this).data('po-id'); // Get the PO ID from the button's data attribute
  console.log("Edit button clicked, PO ID:", order_id);

  // Simulating data pre-population (you can replace with real data fetching if needed)
  // Here you can fill the modal form with values that will be updated.
  $('#editdata').find('input[name="po_id"]').val(order_id);
  $('#editdata').find('input[name="product_name"]').val("Sample Product");  // Example data
  $('#editdata').find('input[name="quantity"]').val(100);  // Example data
  $('#editdata').find('input[name="qty_received"]').val(0);  // Example data
  $('#editdata').find('input[name="supplier_name"]').val("Sample Supplier");  // Example data
  $('#editdata').find('input[name="status"]').val("Pending");  // Example data

  // Show the modal for editing
  $('#editdata').modal('show');
});

// Submit the form data to update
$('#updateForm').on('submit', function(e) {
  e.preventDefault();

  var formData = $(this).serialize(); // Serialize form data for AJAX

  $.ajax({
    method: "POST",
    url: "po_actions.php", // PHP file that handles the update
    data: formData,
    success: function(response) {
      alert('Data successfully updated!');
      $('#editdata').modal('hide');
      location.reload(); // Optionally, refresh the page or update the view
    },
    error: function(xhr, status, error) {
      console.error("AJAX error:", error);
    }
  });
});

});

$(document).ready(function () {
    // Handle the "Edit" button click
    $(document).on('click', '.edit_data', function(e) {
        e.preventDefault();

        var po_id = $(this).data('po-id'); // Get the PO ID from the button's data attribute
        console.log("Edit button clicked, PO ID:", po_id);

        // Send an AJAX request to get the current data for the PO
        $.ajax({
            method: "POST",
            url: "po_actions.php", // The PHP file that handles getting PO data
            data: { click_edit_btn: true, po_id: po_id },
            success: function(response) {
                if(response) {
                    var data = JSON.parse(response); // Parse JSON response

                    // Populate the modal form with data
                    $('#editdata').find('input[name="po_id"]').val(data.id);
                    $('#editdata').find('input[name="product_name"]').val(data.product_name);
                    $('#editdata').find('input[name="quantity"]').val(data.quantity);
                    $('#editdata').find('input[name="qty_received"]').val(data.qty_received);
                    $('#editdata').find('input[name="supplier_name"]').val(data.supplier_name);
                    $('#editdata').find('input[name="status"]').val(data.status);

                    // Show the modal for editing
                    $('#editdata').modal('show');
                } else {
                    alert('Error fetching PO data.');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    });

    // Submit the form data to update
    $('#updateForm').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize(); // Serialize form data for AJAX

        $.ajax({
            method: "POST",
            url: "po_actions.php", // PHP file that handles the update
            data: formData,
            success: function(response) {
                alert('Data successfully updated!');
                $('#editdata').modal('hide');
                location.reload(); // Optionally, refresh the page or update the view
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    });
});












  



  </script>
</body>

</html>
<?php include('function/viewdata.js'); ?>
<?php include('function/editdata.js'); ?>
<?php include('function/remove.js'); ?>