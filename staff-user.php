<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="order.css">
    <title>Food & Orders</title>
</head>
 <!-- Modal -->
 <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">Order Summary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cash">Cash</button>
                    <button type="button" class="btn-epayment">E-Payment</button>
                </div>
            </div>
        </div>
    </div>
<!-- Discount -->
    <div class="modal fade" id="discountModal" tabindex="-1" aria-labelledby="discountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="discountModalLabel">Apply Discount</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="discountCodeInput" class="form-label">Enter Discount Code</label>
                    <input type="text" class="form-control" id="discountCodeInput" placeholder="Enter code here">
                </div>
                <p class="text-danger" id="discountError" style="display:none;">Invalid code or already applied!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="applyDiscountButton">Apply Discount</button>
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
            </a>
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
                <h2 class="fs-3 m-1">Food and Orders</h2>
            </div>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-1 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold notification-link " href="#"
                            style="color: black; font-weight: 200; font-size: 17px;" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="icons/ecommerce-shop-transaction-svgrepo-com.svg" alt="" class="topnavbar-icons">
                            Transaction
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">History</a></li>
                            <li><a class="dropdown-item" href="#">Void Transaction</a></li>
                        </ul>
                    </li>
                    <a class="nav-link fw-bold notification-link me-2" href="#"
                        style="color: black; font-weight: 200; font-size: 17px;">
                        <img src="icons/notifications-alert-svgrepo-com.svg" alt="" class="topnavbar-icons">
                        Notifications
                    </a>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold notification-link " href="#"
                            style="color: black; font-weight: 200; font-size: 17px;" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="icons/profile-round-1342-svgrepo-com.svg" alt="" class="user-icons">
                            Admin
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

        <div class="container-fluid">
            <div class="order-container">
                <header>
                    <div class="name-text">
                        <span class="label-name" id="best-seller">Best Seller Coffee Drinks</span>
                    </div>
                </header>
                <div class="content flex">
                    <div class="coffee-card me-3">
                        <div class="quantity">
                            <div class="details">
                                <h3 class="coffee-name">Americano</h3>
                                <span class="coffee-price">P100</span>
                            </div>
                            <img src="images/Americano.png" alt="Americano" />
                            <div class="addtocart">Add to Cart</div>
                        </div>
                    </div>
                </div>
                <header>
                    <div class="name-text">
                        <span class="label-name" id="espresso-coffee">Espresso Based Coffee</span>
                    </div>
                </header>
                <div class="content">
                    <div class="coffee-card me-3">
                        <div class="quantity">
                            <div class="details">
                                <h3 class="coffee-name">Americano</h3>
                                <span class="coffee-price">P100</span>
                            </div>
                            <img src="images/Americano.png" alt="Americano" />
                            <div class="addtocart">Add to Cart</div>
                        </div>
                    </div>
                </div>
                <header>
                    <div class="name-text">
                        <span class="label-name" id="fruit-tea">Fruit Tea</span>
                    </div>
                </header>
                <div class="content">
                    <div class="coffee-card me-3">
                        <div class="quantity">
                            <div class="details">
                                <h3 class="coffee-name">Americano</h3>
                                <span class="coffee-price">P100</span>
                            </div>
                            <img src="images/Americano.png" alt="Americano" />
                            <div class="addtocart">Add to Cart</div>
                        </div>
                    </div>
                </div>
                <header>
                    <div class="name-text">
                        <span class="label-name" id="mocktails">Mocktails</span>
                    </div>
                </header>
                <div class="content">
                    <div class="coffee-card me-3">
                        <div class="quantity">
                            <div class="details">
                                <h3 class="coffee-name">Americano</h3>
                                <span class="coffee-price">P100</span>
                            </div>
                            <img src="images/Americano.png" alt="Americano" />
                            <div class="addtocart">Add to Cart</div>
                        </div>
                    </div>
                </div>
                <header>
                    <div class="name-text">
                        <span class="label-name" id="smoothies">Smoothies</span>
                    </div>
                </header>
                <div class="content">
                    <div class="coffee-card me-3">
                        <div class="quantity">
                            <div class="details">
                                <h3 class="coffee-name">Americano</h3>
                                <span class="coffee-price">P100</span>
                            </div>
                            <img src="images/Americano.png" alt="Americano" />
                            <div class="addtocart">Add to Cart</div>
                        </div>
                    </div>
                </div>
                <header>
                    <div class="name-text">
                        <span class="label-name" id="frappe">Frappe</span>
                    </div>
                </header>
                <div class="content">
                    <div class="coffee-card me-3">
                        <div class="quantity">
                            <div class="details">
                                <h3 class="coffee-name">Americano</h3>
                                <span class="coffee-price">P100</span>
                            </div>
                            <img src="images/Americano.png" alt="Americano" />
                            <div class="addtocart">Add to Cart</div>
                        </div>
                    </div>
                </div>
                <header>
                    <div class="name-text">
                        <span class="label-name" id="croffle">Croffle</span>
                    </div>
                </header>
                <div class="content">
                    <div class="coffee-card me-3">
                        <div class="quantity">
                            <div class="details">
                                <h3 class="coffee-name">Americano</h3>
                                <span class="coffee-price">P100</span>
                            </div>
                            <img src="images/Americano.png" alt="Americano" />
                            <div class="addtocart">Add to Cart</div>
                        </div>
                    </div>
                </div>
                <header>
                    <div class="name-text">
                        <span class="label-name" id="fries">Fries</span>
                    </div>
                </header>
                <div class="content">
                    <div class="coffee-card me-3">
                        <div class="quantity">
                            <div class="details">
                                <h3 class="coffee-name">Americano</h3>
                                <span class="coffee-price">P100</span>
                            </div>
                            <img src="images/Americano.png" alt="Americano" />
                            <div class="addtocart">Add to Cart</div>
                        </div>
                    </div>
                    <div class="coffee-card me-3">
                        <div class="quantity">
                            <div class="details">
                                <h3 class="coffee-name">Latte</h3>
                                <span class="coffee-price">P150</span>
                            </div>
                            <img src="images/Americano.png" alt="Americano" />
                            <div class="addtocart">Add to Cart</div>
                        </div>
                    </div>
                </div>
                <header>
                    <div class="name-text">
                        <span class="label-name" id="cakes">Cakes</span>
                    </div>
                </header>
                <div class="content">
                    <div class="coffee-card me-3">
                        <div class="quantity">
                            <div class="details">
                                <h3 class="coffee-name">Americano</h3>
                                <span class="coffee-price">P100</span>
                            </div>
                            <img src="images/Americano.png" alt="Americano" />
                            <div class="addtocart">Add to Cart</div>
                        </div>
                    </div>
                </div>
                <header>
                    <div class="name-text">
                        <span class="label-name" id="sandwich">Sandwich</span>
                    </div>
                </header>
                <div class="content">
                    <div class="coffee-card me-3">
                        <div class="quantity">
                            <div class="details">
                                <h3 class="coffee-name">Americano</h3>
                                <span class="coffee-price">P100</span>
                            </div>
                            <img src="images/Americano.png" alt="Americano" />
                            <div class="addtocart">Add to Cart</div>
                        </div>
                    </div>
                </div>
                <header>
                    <div class="name-text">
                        <span class="label-name" id="rice">Rice Meal</span>
                    </div>
                </header>
                <div class="content">
                    <div class="coffee-card me-3">
                        <div class="quantity">
                            <div class="details">
                                <h3 class="coffee-name">Americano</h3>
                                <span class="coffee-price">P100</span>
                            </div>
                            <img src="images/Americano.png" alt="Americano" />
                            <div class="addtocart">Add to Cart</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="receipt receipt-fluid">
                <div class="top-cart">
                    <h3 class="cart-name">Cart</h3>
                </div>
                <h3 class="order-name">Order Items</h3>
                <div class="order-list">
                </div>
                <div class="total-price">
                    <div class="form-check">
                        <button class="btn-discount" data-bs-toggle="discount" data-bs-target="#discountModal">Add Discount</button>
                    </div>
                    <div class="total-amount">
                        Subtotal:
                    </div>
                </div>
                <button class="btn-order" data-bs-toggle="modal" data-bs-target="#checkoutModal">Check Out</button>
            </div>
        </div>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: "#navbarSupportedContent"
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
    const addToCartButtons = document.querySelectorAll(".addtocart");
    const orderList = document.querySelector(".order-list");
    const totalAmountElement = document.querySelector(".total-amount");
    const applyDiscountButton = document.getElementById("applyDiscountButton");
    const discountCodeInput = document.getElementById("discountCodeInput");
    const discountError = document.getElementById("discountError");
    let orderNumber = 1;
    let isDiscountApplied = false;
    const validDiscountCode = "SAVE20"; // Example discount code

    const updateTotalPrice = () => {
        let total = 0;

        document.querySelectorAll(".order-item").forEach((item) => {
            const priceElement = item.querySelector(".price-item").innerText;
            const quantityInput = item.querySelector(".quantity-input");
            const price = parseFloat(priceElement.replace(/[^\d.-]/g, ''));
            const quantity = parseInt(quantityInput.value, 10);

            total += price * quantity;
        });

        // Apply discount if it has been triggered
        if (isDiscountApplied) {
            total *= 0.8; // Apply 20% discount
        }

        totalAmountElement.innerHTML = `Total: P${total.toFixed(2)}`;
    };

    addToCartButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const coffeeCard = this.closest(".coffee-card");
            const coffeeName = coffeeCard.querySelector(".coffee-name").innerText;
            const coffeePrice = coffeeCard.querySelector(".coffee-price").innerText;

            const orderItem = document.createElement("div");
            orderItem.classList.add("order-item");

            orderItem.innerHTML = `
                <img src="images/Americano.png" alt="Americano" class="order-img" />
                <span class="me-3 name-item">${coffeeName}</span>
                <span class="me-2 price-item">${coffeePrice}</span>
                <input type="number" class="quantity-input" value="1" min="1" />
                <img src="icons/trash-alt-svgrepo-com.svg" alt="trash" class="remove remove-item" />
            `;

            // Handle quantity change
            const quantityInput = orderItem.querySelector(".quantity-input");
            quantityInput.addEventListener("input", updateTotalPrice);

            // Handle item removal
            const removeButton = orderItem.querySelector(".remove-item");
            removeButton.addEventListener("click", function () {
                orderItem.remove();
                updateTotalPrice();
            });

            orderList.appendChild(orderItem);
            updateTotalPrice();

            document.querySelector(".order-number").innerText = `Order: #${orderNumber}`;
        });
    });

    applyDiscountButton.addEventListener("click", function () {
        const enteredCode = discountCodeInput.value.trim();

        if (enteredCode === validDiscountCode && !isDiscountApplied) {
            isDiscountApplied = true;
            discountError.style.display = "none";
            updateTotalPrice();
            alert("Discount applied successfully!");
            const discountModal = bootstrap.Modal.getInstance(document.getElementById("discountModal"));
            discountModal.hide();
        } else {
            discountError.style.display = "block";
        }
    });
});

</script>
    
</html>