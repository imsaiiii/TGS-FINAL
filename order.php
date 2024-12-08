<?php session_start();include('connection.php');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="order.css">
    <title>Food & Orders</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <!-- Checkout Modal -->
    <div id="checkoutModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Purchase</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="totalPriceInput" class="form-label">Total Amount:</label>
                            <input type="text" class="form-control" id="totalPriceInput" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="applyDiscount('PWD')">PWD Discount</button>
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#discountModal">Senior Discount</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Discount -->
    <div class="modal fade" id="discountModal" tabindex="-1" aria-labelledby="discountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="discountModalLabel">Apply Discount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Please choose a discount option:</p>
                    <button class="btn btn-primary" onclick="applyDiscount('PWD')">PWD Discount</button>
                    <button class="btn btn-primary" onclick="applyDiscount('SENIOR')">Senior Discount</button>
                    <p class="text-danger mt-3" id="discountError" style="display:none;">Invalid credentials!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex content">
        <div id="sidebar" class="sidebar-color">
            <div class="sidebar-heading">
                <img src="Images/Logo.jpg" alt="Bootstrap" class="logo me-3">The Good Shots
            </div>
            <div class="list-group list-group-flush mt-2">
                <a href="#espresso-coffee" class="list-group-item">
                    <img src="icons/coffee-svgrepo-com.svg" alt="" class="icons me-3">Espresso Base Coffee
                </a>
                <a href="#fruit-tea" class="list-group-item">
                    <img src="icons/fruit-juice-orange-svgrepo-com.svg" alt="" class="icons me-3">Fruit Tea
                </a>
                <a href="#mocktails" class="list-group-item">
                    <img src="icons/cocktails-cocktail-svgrepo-com.svg" alt="" class="icons me-3">Mocktails
                </a>
                <a href="#smoothies" class="list-group-item">
                    <img src="icons/juice-svgrepo-com (1).svg" alt="" class="icons me-3">Smoothies
</a >
                    <a href="#frappe" class="list-group-item">
                    <img src="icons/frappe-svgrepo-com (1).svg" alt="" class="icons me-3">Frappe
                </a>
                <a href="#croffle" class="list-group-item">
                    <img src="icons/waffle-svgrepo-com.svg" alt="" class="icons me-3">Croffle
                </a>
                <a href="#fries" class="list-group-item">
                    <img src="icons/french-fries-svgrepo-com.svg" alt="" class="icons me-3">Fries
                </a>
                <a href="#cakes" class="list-group-item">
                    <img src="icons/cake-4-svgrepo-com.svg" alt="" class="icons me-3">Cakes
                </a>
                <a href="#sandwich" class="list-group-item">
                    <img src="icons/sandwich-svgrepo-com (1).svg" alt="" class="icons me-3">Sandwich
                </a>
                <a href="#rice" class="list-group-item">
                    <img src="icons/rice-svgrepo-com (1).svg" alt="" class="icons me-3">Rice Meal
                </a>
            </div>
        </div>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent px-4 mt-2 dashboard-nav">
                <div class="d-flex align-items-center">
                    <a href="dashboard.php" class="btn-back me-4"><img src="icons/back-svgrepo-com.svg" alt="" class="back-icon"></a>
                    <h2 class="fs-3 m-1">Food and Orders</h2>
                </div>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-1 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold notification-link" href="#" style="color: black; font-weight: 200; font-size: 17px;" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="icons/ecommerce-shop-transaction-svgrepo-com.svg" alt="" class="topnavbar-icons">Transaction
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">History</a></li>
                                <li><a class="dropdown-item" href="#">Void Transaction</a></li>
                            </ul>
                        </li>
                        <a class="nav-link fw-bold notification-link me-2" href="#" style="color: black; font-weight: 200; font-size: 17px;">
                            <img src="icons/notifications-alert-svgrepo-com.svg" alt="" class="topnavbar-icons">Notifications
                        </a>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold notification-link" href="#" style="color: black; font-weight: 200; font-size: 17px;" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="icons/profile-round-1342-svgrepo-com.svg" alt="" class="user-icons">Admin
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="#">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container-responsive d-flex ms-2">
                <div class="order-container">
                    <?php
                    require_once 'connection.php';
                    $categories = ['Espresso', 'Fruit Tea', 'Mocktails', 'Smoothies', 'Frappe', 'Croffle', 'Fries', 'Cakes', 'Sandwich', 'Rice Meal'];

                    foreach ($categories as $category) {
                        $sql = "SELECT * FROM product WHERE category = :category";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute(['category' => $category]);
                        $stmt->setFetchMode(PDO::FETCH_ASSOC);

                        if ($stmt->rowCount() > 0) {
                            echo "<header><div class='name-text'><span class='label-name ' id='" . strtolower(str_replace(' ', '-', $category)) . "'>$category</span></div></header>";
                            echo "<div class='content flex'><div class='product-list'>";

                            while ($row = $stmt->fetch()) {
                                echo "<div class='coffee-card flex me-3'>
                                        <div class='quantity'>
                                            <div class='details'>
                                                <h3 class='coffee-name'>{$row['product_name']}</h3>
                                                <span class='coffee-price'>P{$row['price']}</span>
                                            </div>
                                            <input style='width: 100%; margin-bottom: 5px;' type='button' class='btn btn-primary' value='Add To Cart' onclick='addToCart(\"{$row['product_id']}\", \"{$row['product_name']}\", {$row['price']})'>
                                        </div>
                                    </div>";
                            }
                            echo "</div></div>";
                        } else {
                            echo "<p>No $category products found</p>";
                        }
                    }
                    ?>
                </div>


                <div class="receipt receipt-responsive">

                <div class="receipt receipt-fluid">

                    <div class="top-cart">
                        <h3 class="cart-name">Cart</h3>
                    </div>
                    <h3 class="order-name">Order Items</h3>
                    <div class="cart">
                        <div id="cart-tbl">
                            <table class="table table-striped table-bordered table-hover" id="cart">
                                <tr id="tbl_head">

                                    <th style="width: 15rem;">Item Name</th>
                                    <th style="width: 2rem;">Qty</th>
                                    <th style="width: 3rem;">Price</th>
                                    <th>Action</th>

                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Sub Total</th>
                                    <th class = "">Action</th>

                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="total-price d-flex justify-content-between align-items-center">
                        <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#discountModal">
                            Add Discount
                        </button>
                        <div class="fw-bold">
                            Subtotal: <span id="totalAmount">P0.00</span>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#checkoutModal" onclick="updateTotalPrice()">
                        Check Out
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
let cart = [];

function addToCart(id, name, price) {
    const existingItem = cart.find(item => item.id === id);
    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({ id, name, price, quantity: 1 });
    }
    updateCartDisplay();
}

function removeFromCart(id) {
    cart = cart.filter(item => item.id !== id);
    updateCartDisplay();
}

function updateCartDisplay() {
    const cartTable = document.getElementById('cart');
    const totalAmountElement = document.getElementById('totalAmount');
    let total = 0;

    while (cartTable.rows.length > 1) {
        cartTable.deleteRow(1);
    }

    cart.forEach(item => {
        const subTotal = item.price * item.quantity;
        total += subTotal;

        const row = cartTable.insertRow();
        row.insertCell(0).innerText = item.name;
        row.insertCell(1).innerText = item.quantity;
        row.insertCell(2).innerText = `P${item.price.toFixed(2)}`;
<<<<<<< HEAD
        const actionCell = row.insertCell(3);
=======
        row.insertCell(3).innerText = `P${subTotal.toFixed(2)}`;
        const actionCell = row.insertCell(4);
>>>>>>> 0499a0af2f7519f2cc67ab2ddc122d46ba9f46bc
        actionCell.innerHTML = `<button class='btn btn-danger' onclick='removeFromCart("${item.id}")'>Remove</button>`;
    });

    totalAmountElement.innerText = `P${total.toFixed(2)}`;
}

function updateTotalPrice() {
    const totalPriceInput = document.getElementById('totalPriceInput');
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    totalPriceInput.value = `P${total.toFixed(2)}`;
}
</script>

</html>