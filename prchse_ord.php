<?php
session_start();
if(!isset($_SESSION['user'])) header('location: login.php');


$_SESSION['table'] = 'tbl_products';
$products = include('database/show_products.php');
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="dashboard.css" />
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="prchse_ord.css">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/> 

  <!-- ICONS -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  <!-- FONTS -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cutive+Mono&display=swap" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <script src="prchse_ord.js"> </script>
  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js"></script>
</head>

<body>
  
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

<!-- White line under the menu option -->
<div class="line"></div>
</div>

<!-- TOP BAR -->
<div class="section">
  <div class="top" id = "myHeader">
    <a href="javascript:void(0)" class="openNav" onclick="openNav()">&#9776;
    </a>

    <!-- ADMIN TEXT AND ICON -->

    <div class="text">
      <a href="profile.php"><span class="sadmin_text" id="user_name"> <?= $user['first_name']?> </span></a>
      <a href="profile.php">
        <i class="fa-solid fa-user-tie fa-2x"></i>
      </a>
    </div>
  </div>

    <div id = "main" class="mainn">
      <div id="low_stock_products" class="low-stock-products"></div>
      <div class = "container">
        <div class="table1">    

        <div id="product_details">
          <?php
          date_default_timezone_set('Asia/Manila'); 
          ?>
          <p>Purchase Order Date and Time: <span id="transactionDate"><?php echo date("Y-m-d h:i:sa"); ?></span></p>
          <p>Purchase Order Number: <span id="transactionNumber"></span></p>
          <hr> 
           
          <div class="search-container">
              <label for="supplier_list" class="label_product"><b>Supplier: </b></label>
              <input type="text" id="searchSupplierInput" placeholder="Search supplier" onkeyup="searchSupplier()" autocomplete="off">
              <select name="supplier_list" size="5" id="supplier_list" onchange="selectSupplier()">
                  <?php
                  $select_supplier = ("SELECT supplier_name FROM tbl_supplier");
                  $supplier_selected = $conn->prepare($select_supplier);
                  $supplier_selected->execute();

                  while ($row = $supplier_selected->fetch(PDO::FETCH_ASSOC)) {
                      $supplier_name = $row['supplier_name'];
                      ?>
                      <option value="<?php echo $supplier_name; ?>"><?php echo $supplier_name; ?></option>
                  <?php } ?>
              </select>
          </div>

          <hr> 

          <div class="search-container">
            <label for="product_list" class="label_product"><b>Product: </b></label>  
            <input type="text" id="searchInput" placeholder="Search product" onkeyup="searchSelect()" autocomplete="off">
            <select name="product_list" size="5" id="product_list" onchange="selectItem()">
              <?php
              $select_subject = ("SELECT product_name FROM tbl_products");
              $subject_selected = $conn -> prepare($select_subject);
              $subject_selected -> execute();

              while ($row = $subject_selected->fetch(PDO::FETCH_ASSOC)) {
                $product_name = $row['product_name'];
                
                ?>   
                <option><?php echo $product_name; ?></option>

              <?php } ?>

            </select>

            <label for="product_qty" class="label_qty">Quantity: </label>
            <input type="number" name="product_qty" id="product_qty" min="1"> 
            <button id="btn_add" onclick="addProduct()">Add Product</button>
          </div>
          
        </div>

        <table id="display">
          <tr>
            <th>Product</th>
            <th>Unit Price</th>
            <th>Quantity</th>
            <th>Amount</th>
            <th>Action</th>
          </tr>
        </table>
        <table id="total">
          <tr>
            <td colspan="3">Total:</td>
            <td colspan="2" id="total_price">0.00</td>
          </tr>
        </table>
        <div id="btn-cancel-continue">
          <button id="cancel-btn" onclick="cancelTransaction()">Cancel</button>
          <button id="continue-btn" onclick="show()">Continue</button>
        </div>
        
      </div>
      <div class="form-group" id="popupForm">
        <div class="form-container">
          <span class="close" id="closeForm" >&times;</span>
          <h2>Confirm Purchase?</h2>
          <form class="popup">
            <label for="totalAmount">Total Amount:</label>
            <input type="text" class="form-control" id="totalPriceInput" readonly>

            <button type="button" class="btn btn-primary" id="confirm_btn">Confirm</button>
            <button type="button" class="btn btn-default" id="popupCancel">Cancel</button>
          </form>
        </div>
      </div>

    </div>
  </div>

<script>

function displayLowStockProducts() {
    var user_id = <?php echo isset($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : 'null'; ?>;
    
    $.ajax({
        method: "POST",
        url: "get_low_stock_products.php",
        data: {
            'low_stock': true,
            'user_id': user_id
        },
        success: function (response) {
            $('#low_stock_products').html(response);
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}

    var header = document.getElementById("myHeader");
    var sticky = header.offsetTop;

    window.addEventListener('scroll', myFunction);

    function generateTransactionNumber() {
      const randomString = Math.random().toString(36).substring(2, 10); 
      const timestamp = new Date().getTime();
      const transactionNumber = `${timestamp}${randomString}`; 
      return transactionNumber;
    }

    const transactionNumberElement = document.getElementById('transactionNumber');
    const randomTransactionNumber = generateTransactionNumber();

    if (transactionNumberElement) {
      transactionNumberElement.textContent = randomTransactionNumber;
    } else {
      console.error("Element with id 'transactionNumber' not found.");
    }

// SUPPLIER FUNCTION
function updateProductList() {
  var supplier = document.getElementById("supplier_list").value;
  console.log('Selected Supplier:', supplier);

  var xhr = new XMLHttpRequest();
  xhr.open("GET", "get_products_by_supplier.php?supplier_name=" + supplier, true);

  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4) {
      console.log('XHR Status:', xhr.status);
      if (xhr.status == 200) {
        var productList = document.getElementById("product_list");
        productList.innerHTML = xhr.responseText;
      } else {
        console.error('Error loading products:', xhr.statusText);
      }
    }
  };

  xhr.send();
}

function selectSupplier() {
  var selectedSupplier = document.getElementById("supplier_list").value;
  document.getElementById("searchSupplierInput").value = selectedSupplier;
  console.log('Selected Supplier:', selectedSupplier);
  updateProductList();
}

</script>
</body>
</html>