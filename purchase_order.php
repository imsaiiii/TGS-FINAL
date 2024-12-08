<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>The Good Shots</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script>
    $(document).ready(function () {
      var table = $('#myTable').DataTable();

    
    });
    
  </script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="dashboard.css" />
  <script src="function/po_database.js"> </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


</head>

<body>
  <?php
  session_start();
  include('connection.php');

  $query = "SELECT po.id, po.po_number, po.created_at, po.qty_received, pod.quantity, pod.product_name, pod.unit_price, pod.supplier_name, pod.status
            FROM purchase_orders po
            LEFT JOIN purchase_order_details pod ON po.id = pod.po_id";

  $query_run = $conn->query($query);
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
              <<?php
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
  <!-- Edit Order Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Purchase Order</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="order_id">
          <div class="form-group">
            <label for="po_number">PO Number</label>
            <input type="text" class="form-control" id="po_number" required>
          </div>
          <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" class="form-control" id="product_name" required>
          </div>
          <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" id="quantity" required>
          </div>
          <div class="form-group">
            <label for="unit_price">Unit Price</label>
            <input type="number" class="form-control" id="unit_price" required>
          </div>
          <div class="form-group">
            <label for="supplier_name">Supplier Name</label>
            <input type="text" class="form-control" id="supplier_name" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="update_order">Update Order</button>
        </div>
      </div>
    </div>
  </div>
  <!-- View Order Modal -->
  <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewModalLabel">View Purchase Order</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p><strong>PO Number:</strong> <span id="view_po_number"></span></p>
          <p><strong>Product Name:</strong> <span id="view_product_name"></span></p>
          <p><strong>Quantity:</strong> <span id="view_quantity"></span></p>
          <p><strong>Unit Price:</strong> <span id="view_unit_price"></span></p>
          <p><strong>Supplier Name:</strong> <span id="view_supplier_name"></span></p>
          <p><strong>Status:</strong> <span id="view_status"></span></p>
          <p><strong>Created At:</strong> <span id="view_created_at"></span></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                      <tr class="<?php echo htmlspecialchars($rowColorClass); ?>">
                        <td hidden><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['po_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($row['qty_received']); ?></td>
                        <td><?php echo htmlspecialchars($row['supplier_name']); ?></td>
                        <td><?php echo htmlspecialchars($status); ?></td>
                        <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($row['created_at']))); ?></td>
                        <td>
                          <button class="btn btn-info btn-sm view_data btn-view" data-bs-toggle="modal"
                            data-bs-target="#viewModal"
                            data-id="<?php echo htmlspecialchars($row['po_number']); ?>">View</button>

                          <button class="btn btn-success btn-sm edit_data btn-edit" data-bs-toggle="modal"
                            data-bs-target="#editModal" data-id="<?php echo htmlspecialchars($row['id']); ?>" <?php echo $disableEdit; ?>>Edit</button>
                          <button class="btn btn-danger btn-sm delete_data btn-delete" data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-id="<?php echo htmlspecialchars($row['id']); ?>">Delete</button>
                        </td>
                      </tr>
                      <?php
                    }
                  } else {
                    echo "<tr><td colspan='10'>No Records Found</td></tr>";
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
    $(document).on('click', '.view_data', function () {
      var id = $(this).data('id');

      $.ajax({
        url: 'po/view_order.php',
        method: 'POST',
        data: { id: id },
        success: function (data) {
          var order = JSON.parse(data);
          if (order.error) {
            alert(order.error);
          } else {
            // Populate modal with order details
            $('#viewModal .modal-body').html(`
                    <p><strong>PO Number:</strong> ${order.po_number}</ <p><strong>Product Name:</strong> ${order.product_name}</p>
                    <p><strong>Quantity:</strong> ${order.quantity}</p>
                    <p><strong>Unit Price:</strong> ${order.unit_price}</p>
                    <p><strong>Supplier Name:</strong> ${order.supplier_name}</p>
                    <p><strong>Status:</strong> ${order.status}</p>
                    <p><strong>Created At:</strong> ${order.created_at}</p>
                `);
            $('#viewModal').modal('show');
          }
        }
      });
    });
    $(document).on('click', '.edit_data', function () {
      var id = $(this).data('id');

      $.ajax({
        url: 'po/fetch_order.php',
        method: 'POST',
        data: { id: id },
        success: function (data) {
          var order = JSON.parse(data);
          if (order.error) {
            alert(order.error);
          } else {
            // Populate edit form with order details
            $('#editModal #po_number').val(order.po_number);
            $('#editModal #product_name').val(order.product_name);
            $('#editModal #quantity').val(order.quantity);
            $('#editModal #unit_price').val(order.unit_price);
            $('#editModal #supplier_name').val(order.supplier_name);
            $('#editModal #order_id').val(order.id);
            $('#editModal').modal('show');
          }
        }
      });
    });

    $('#editModal #update_order').on('click', function () {
      var id = $('#editModal #order_id').val();
      var poNumber = $('#editModal #po_number').val();
      var productName = $('#editModal #product_name').val();
      var quantity = $('#editModal #quantity').val();
      var unitPrice = $('#editModal #unit_price').val();
      var supplierName = $('#editModal #supplier_name').val();

      $.ajax({
        url: 'po/update_order.php',
        method: 'POST',
        data: {
          id: id,
          po_number: poNumber,
          product_name: productName,
          quantity: quantity,
          unit_price: unitPrice,
          supplier_name: supplierName
        },
        success: function (response) {
          var res = JSON.parse(response);
          if (res.success) {
            alert('Order updated successfully!');
            location.reload(); // Reload the page to see changes
          } else {
            alert(res.message);
          }
        }
      });
    });
    $(document).on('click', '.delete_data', function () {
      var id = $(this).data('id');
      $('#deleteModal #confirm_delete').data('id', id); // Store ID in the confirm button
      $('#deleteModal').modal('show');
    });

    $('#deleteModal #confirm_delete').on('click', function () {
      var id = $(this).data('id');

      $.ajax({
        url: 'po/delete_order.php',
        method: 'POST',
        data: { id: id },
        success: function (response) {
          var res = JSON.parse(response);
          if (res.success) {
            alert('Order deleted successfully!');
            location.reload(); // Reload the page to see changes
          } else {
            alert(res.message);
          }
        }
      });
    });
  </script>
</body>

</html>
<?php include('function/viewdata.js'); ?>
<?php include('function/editdata.js'); ?>
<?php include('function/remove.js'); ?>