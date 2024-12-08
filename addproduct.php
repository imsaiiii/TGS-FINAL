<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>The Good Shots</title>
  <!--function of Add new Product -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

  <script>
    $(document).ready(function () {
      $('#product').DataTable();
    });
  </script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="dashboard.css" />
  <title>The Good Shots</title>
  <!---->
</head>

<body>

  <?php
  include('add.php');
  ?>
  <!-- Add Product Modal -->
<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="insertdataLabel" aria-hidden="true">
    <div class="modal-dialog custom-modal-product">
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
                        <img id="imagePreview" src="" alt="Image Preview" style="max-width: 150px; max-height: 150px; display: none;">
                    </div>
                    <div class="mb-3">
                        <h2>Ingredients</h2>
                        <div id="ingredients-container">
                            <div class="ingredient mb-3" id="ingredient_1">
                                <label for="ingredient_name_1">Select Ingredient:</label>
                                <select class="form-control fw-medium" id="ingredient_name_1" name="ingredient_name[]" required>
                                    <option value="">-- Select Ingredient --</option>
                                    <?php
                                    include('connection.php');
                                    $stmt = $conn->prepare("SELECT product_name FROM inventory");
                                    $stmt->execute();
                                    $result = $stmt->fetchAll();
                                    foreach ($result as $row) {
                                        echo "<option value='" . htmlspecialchars($row['product_name']) . "'>" . htmlspecialchars($row['product_name']) . "</option>";
                                    }
                                    ?>
                                </select>
                                <label for="quantity_1">Quantity:</label>
                                <input type="number" class="form-control" id="quantity_1" name="quantity[]" required>
                                <label for="unit_1">Unit:</label>
                                <select class="form-control fw-medium" id="unit_1" name="unit[]" required>
                                    <option value="">-- Select Unit --</option>
                                    <option value="milliliter">milliliter</option>
                                    <option value="grams">grams</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" id="add-ingredient">Add Another Ingredient</button>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">-- Select Category --</option>
                            <?php
                            $stmt = $conn->prepare("SELECT name FROM category");
                            $stmt->execute();
                            $result = $stmt->fetchAll();
                            foreach ($result as $row) {
                                echo "<option value='" . htmlspecialchars($row['name']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                            }
                            ?>
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

<!-- Edit Product Modal -->
<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-modal-product">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-registration-form" method="POST" action="code.php" enctype="multipart/form-data">
                    <input type="hidden" id="editProductId" name="product_id">
                    <div class="mb-3">
                        <label for="editProductName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="editProductName" name="productname" required>
                    </div>
                    <div class="mb-3">
                        <label for="editImage" class="form-label">Image</label>
                        <input type="file" class="form-control" id="editImage" name="image" accept=".jpg, .jpeg, .png" onchange="previewEditImage(event)">
                        <img id="editImagePreview" src="" alt="Image Preview" style="max-width: 150px; max-height: 150px; display: none;">
                    </div>
                    <div class="mb-3">
                        <h2>Ingredients</h2>
                        <div id="edit-ingredients-container">
                            <!-- Existing ingredients will be populated here -->
                        </div>
                        <button type="button" class="btn btn-primary" id="add-edit-ingredient">Add Another Ingredient</button>
                    </div>
                    <div class="mb-3">
                        <label for="editPrice" class="form-label">Price</label>
                        <input type="text" class="form-control" id="editPrice" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCategory" class="form-label">Category</label>
                        <select class="form-select" id="editCategory" name="category" required>
                            <option value="">-- Select Category --</option>
                            <?php
                            $stmt = $conn->prepare("SELECT name FROM category");
                            $stmt->execute();
                            $result = $stmt->fetchAll();
                            foreach ($result as $row) {
                                echo "<option value='" . htmlspecialchars($row['name']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="update_product">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Product Modal -->
<div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProductModalLabel">View Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="viewImage" src="" alt="Product Image" style="max-width: 100%; max-height: 200px;">
                <h5 id="viewProductName"></h5>
                <p><strong>Price:</strong> <span id="viewPrice"></span></p>
                <p><strong>Category:</strong> <span id="viewCategory"></span></p>
                <h6>Ingredients:</h6>
                <ul id="viewIngredients"></ul>
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
        <a href="addproduct.php" class="list-group-item active">
          <i class="fa-brands fa-product-hunt me-3"></i>Product Management
        </a>
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


      <div class="container-responsive mt-5">
        <div class="row justify-content-center">
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
                <button type="button" class="btn btn-primary float-end fw-medium" data-bs-toggle="modal"
                  data-bs-target="#addProductModal">
                  Add New Product
                </button>
              </div>
              <div class="card-body mt-1">
                <table id="product" class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Product Name</th>
                      <th scope="col">Price</th>
                      <th scope="col">Category</th>
                      <th scope="col">Image</th>
                      <th scope="col" class="action-column">Actions</th>


                    </tr>
                  </thead>
                  <tbody>
                    <?php
include 'connection.php'; // Ensure this file sets up the PDO connection


// Prepare and execute the fetch query
$fetch_query = "SELECT * FROM product";
$stmt = $conn->prepare($fetch_query);
$stmt->execute();

// Check if there are results
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td class="productid"><?php echo htmlspecialchars($row['product_id']); ?></td>
            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
            <td><?php echo htmlspecialchars($row['price']); ?></td>
            <td><?php echo htmlspecialchars($row['category']); ?></td>
            <td>
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Product Image"
                     style="max-width: 80px; max-height: 80px;">
            </td>
            <td>
                <a href="#" class="btn btn-info btn-base view_product btn-view">View Data</a>
                <a href="#" class="btn btn-success btn-base edit_product btn-edit">Edit Data</a>
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
    </div>
  </div>
</body>
<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById('imagePreview');
        output.src = reader.result; // Set the src of the image to the result from FileReader
        output.style.display = 'block'; // Show the image preview
        document.getElementById('remove-image').style.display = 'inline-block'; // Show the remove button
    };
    reader.readAsDataURL(event.target.files[0]); // Read the uploaded file as a data URL
}
    function removeImage() {
        document.getElementById('imagePreview').src = '';
        document.getElementById('imagePreview').style.display = 'none';
        document.getElementById('image').value= '';
        document.getElementById('remove-image').style.display = 'none';
    }
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

  document.getElementById('add-ingredient').addEventListener('click', function () {
        const container = document.getElementById('ingredients-container');
        const index = container.children.length + 1;

        const newIngredient = `
            <div class="ingredient mb-3" id="ingredient_${index}">
                <label for="ingredient_name_${index}">Select Ingredient:</label>
                <select class="form-control fw-medium" id="ingredient_name_${index}" name="ingredient_name[]" required>
                    <option value="">-- Select Ingredient --</option>
                    <?php
                    include('connection.php');
                    $stmt = $conn->prepare("SELECT product_name FROM inventory");
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                    foreach ($result as $row) {
                        echo "<option value='" . htmlspecialchars($row['product_name']) . "'>" . htmlspecialchars($row['product_name']) . "</option>";
                    }
                    $conn = null;
                    ?>
                </select>

                <label for="quantity_${index}">Quantity:</label>
                <input type="number" class="form-control" id="quantity_${index}" name="quantity[]" required>

                <label for="unit_${index}">Unit:</label>
                <select class="form-control fw-medium" id="unit_${index}" name="unit[]" required>
                    <option value="">-- Select Unit --</option>
                    <option value="milliliter">milliliter</option>
                    <option value="grams">grams</option>
                </select>

                <button type="button" class="btn btn-danger" onclick="removeIngredient(${index})">Remove</button>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', newIngredient);
    });

    function removeIngredient(index) {
        const ingredientDiv = document.getElementById(`ingredient_${index}`);
        if (ingredientDiv) {
            ingredientDiv.remove();
        }
    }
   
</script>

</html>
<?php include('function/viewdata.js'); ?>
<?php include('function/editdata.js'); ?>
<?php include('function/remove.js'); ?>