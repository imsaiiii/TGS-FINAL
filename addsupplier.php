<?php session_start();
include('connection.php'); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,, initial-scale=1.0" />

    <title>The Good Shots</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script>
        $(document).ready(function () {
            $('#supplierTable').DataTable();
        });
    </script>
    <!-- Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="dashboard.css" />

</head>

<body>
    <!--Add-->
    <div class="modal fade" id="addUserData" tabindex="-1" aria-labelledby="addUser DataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addUser DataLabel">Add New Supplier</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="code.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="supplier_name" class="form-label">Supplier Name</label>
                            <input type="text" class="form-control" name="supplier_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" name="contact_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add_supplier" class="btn btn-primary">Add Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSupplierModalLabel">Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="code.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label for="suppliername" class="form-label">Supplier Name</label>
                            <input type="text" class="form-control" name="suppliername" required>
                        </div>
                        <div class="mb-3">
                            <label for="contactnumber" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" name="contactnumber" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="update_supplier" class="btn btn-primary">Update Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- View User Modal -->
    <div class="modal fade" id="viewitemModal" tabindex="-1" aria-labelledby="viewitemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewitemModalLabel">View Supplier</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="view_item_data"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
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
                <div class="product-dropdown">
                    <a href="addproduct.php" class="list-group-item" id="product-toggle">
                        <i class="fa-brands fa-product-hunt me-3"></i>Product Management
                    </a>
                </div>
                <a href="inventoryManage.php" class="list-group-item">
                    <i class="fas fa-shopping-cart me-3"></i>Inventory Management
                </a>
                <a href="purchase_order.php" class="list-group-item">
                    <i class="fa-solid fa-money-bill me-3"></i>Purchase Order
                </a>
                <div class="s     upplier-dropdown">
                    <a href="#" class="list-group-item active" id="supplier-toggle">
                        <i class="fa-solid fa-boxes-packing me-3"></i>Supplier<i
                            class="fa-solid fa-chevron-right toggle-arrow-supplier" id="supplier-arrow"></i>
                    </a>
                    <div class="submenu" id="supplier-submenu">
                        <a href="addsupplier.php" class="sub-list-item active">
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
                    <h2 class="fs-3 m-1">Add Supplier</h2>
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
                                Admin
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <<<<<<< HEAD <li><a class="dropdown-item" href="#">Profile</a>
                        </li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Logout</a></li>
                    </ul>
                    </li>
                    </ul>
                </div>
            </nav>

            <div class="container-responsive">
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
                    <div class="card shadow mt-5">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary float-end fw-medium btn-add"
                                data-bs-toggle="modal" data-bs-target="#addUserData">
                                Add New Supplier
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="supplierTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Supplier Name</th>
                                        <th scope="col">Contact Number</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" class="action-column">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include 'connection.php'; // Ensure this file sets up a PDO connection
                                    
                                    try {
                                        // Prepare the SQL statement
                                        $fetch_query = "SELECT * FROM suppliers";
                                        $stmt = $conn->prepare($fetch_query);

                                        // Execute the statement
                                        $stmt->execute();

                                        // Fetch all results
                                        $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        if (count($suppliers) > 0) {
                                            foreach ($suppliers as $row) {
                                                ?>
                                                <tr>
                                                    <td class="supplier_id"><?php echo htmlspecialchars($row['id']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['supplier_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-info btn-base delete_supplier_products btn-view"
                                                            data-id="<?php echo htmlspecialchars($row['id']); ?>">View</a>
                                                        <a href="#" class="btn btn-success btn-base edit_supplier_products btn-edit"
                                                            data-id="<?php echo htmlspecialchars($row['id']); ?>">Edit</a>
                                                        <a href="#" class="btn btn-danger btn-base deletesupp btn-delete"
                                                            data-id="<?php echo htmlspecialchars($row['id']); ?>">Delete</a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="5" class="text-center">No Record Found</td>
                                            </tr>
                                            <?php
                                        }
                                    } catch (PDOException $e) {
                                        echo "Error: " . $e->getMessage();
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