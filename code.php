<?php

session_start();
include 'connection.php'; 


// User Registration

if (isset($_POST['save_user'])) {
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $role = htmlspecialchars($_POST['role']);

    try {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['status'] = "Username already exists";
        } else {
            if (strlen($password) < 8) {
                $_SESSION['status'] = "Password must be at least 8 characters long.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (first_name, last_name, username, email, password, role) VALUES (:first_name, :last_name, :username, :email, :password, :role)";
                
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':first_name', $first_name);
                $stmt->bindParam(':last_name', $last_name);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':role', $role);
                
                if ($stmt->execute()) {
                    $_SESSION['status'] = "User  registered successfully.";
                    header("Location: adduser.php");
                    exit();
                } else {
                    $_SESSION['status'] = "Error in registration. Please try again.";
                }
            }
        }
    } catch (PDOException $e) {
        $_SESSION['status'] = "Database query failed: " . $e->getMessage();
    }
}



// View User
if (isset($_POST['click_view_btn'])) {
    $id = $_POST['user_id'];
    $fetch_query = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($fetch_query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '
            <h6>ID: ' . $row['id'] . '</h6>
            <h6>First Name: ' . $row['first_name'] . '</h6>
            <h6>Last Name: ' . $row['last_name'] . '</h6>
            <h6>Email: ' . $row['email'] . '</h6>
            <h6>Role: ' . $row['role'] . '</h6>
            ';
        }
    } else {
        echo '<h4>No records found</h4>';
    }
}

// Edit User
if (isset($_POST['click_edit_btn'])) {
    $id = $_POST['user_id'];
    $fetch_query = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($fetch_query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $arrayresult = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($arrayresult, $row);
        }
        header('Content-Type: application/json');
        echo json_encode($arrayresult);
    } else {
        echo json_encode([]);
    }
}

// Update User
if (isset($_POST['update_data'])) {
    $id = $_POST['id'];
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $update_query = "UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, password = :password, role = :role WHERE id = :id";
    $stmt = $conn->prepare($update_query);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Data updated successfully";
        header('location: adduser.php');
        exit();
    } else {
        $_SESSION['status'] = "Data update failed: " . $stmt->errorInfo()[2];
        header('location: adduser.php');
        exit();
    }
}

// Delete User
if (isset($_POST['click_delete_btn'])) {
    $id = $_POST['user_id'];
    $delete_query = "DELETE FROM users WHERE id = :id";
    $stmt = $conn->prepare($delete_query);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Data deleted successfully";
    } else {
        $_SESSION['status'] = "Data deletion failed: " . $stmt->errorInfo()[2];
    }
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['add_supplier'])) {
    $supplier_name = htmlspecialchars($_POST['supplier_name']);
    $contact_number = htmlspecialchars($_POST['contact_number']);
    $status = htmlspecialchars($_POST['status']);

    try {
        $stmt = $conn->prepare("SELECT * FROM suppliers WHERE supplier_name = :supplier_name");
        $stmt->bindParam(':supplier_name', $supplier_name);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['status'] = "Supplier already exists!";
        } else {
            $insert_stmt = $conn->prepare("INSERT INTO suppliers (supplier_name, contact_number, status) VALUES (:supplier_name, :contact_number, :status)");
            $insert_stmt->bindParam(':supplier_name', $supplier_name);
            $insert_stmt->bindParam(':contact_number', $contact_number);
            $insert_stmt->bindParam(':status', $status);

            if ($insert_stmt->execute()) {
                $_SESSION['status'] = "Supplier added successfully!";
            } else {
                $_SESSION['status'] = "Error: " . $insert_stmt->errorInfo()[2];
            }
        }
    } catch (PDOException $e) {
        $_SESSION['status'] = "Database query failed: " . $e->getMessage();
    }
    header("Location: addsupplier.php");
    exit();
}



// View Supplier
if (isset($_POST['click_view_supp_btn'])) {
    $id = $_POST['supplier_id'];
    $fetch_query = "SELECT * FROM suppliers WHERE id = :id";
    $stmt = $conn->prepare($fetch_query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '
            <h6>ID: ' . $row['id'] . '</h6>
            <h6>Supplier Name: ' . $row['supplier_name'] . '</h6>
            <h6>Contact Number: ' . $row['contact_number'] . '</h6>
            <h6>Status: ' . $row['status'] . '</h6>
         
            ';
        }
    } else {
        echo '<h4>No records found</h4>';
    }
}

// Edit User
if (isset($_POST['click_edit_btn'])) {
    $id = $_POST['user_id'];
    $fetch_query = "SELECT * FROM users WHERE id     = :id";
    $stmt = $conn->prepare($fetch_query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $arrayresult = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($arrayresult, $row);
        }
        header('Content-Type: application/json');
        echo json_encode($arrayresult);
    } else {
        echo json_encode([]);
    }
}
// Edit User
if (isset($_POST['click_edit_supp_btn'])) {
    $id = $_POST['supplier_id'];
    $fetch_query = "SELECT * FROM suppliers WHERE id = :id";
    $stmt = $conn->prepare($fetch_query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $arrayresult = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($arrayresult, $row);
        }
        header('Content-Type: application/json');
        echo json_encode($arrayresult);
    } else {
        echo json_encode([]);
    }
}
// Edit Supplier


// Update Supplier
if (isset($_POST['update_supplier'])) {
    $id = $_POST['id'];
    $supplier_name = $_POST['suppliername'];
    $contact_number = $_POST['contactnumber'];
    $status = $_POST['status'];

    try {
        $update_query = "UPDATE suppliers SET supplier_name = :supplier_name, contact_number = :contact_number, status = :status WHERE id = :id";
        $stmt = $conn->prepare($update_query);
        $stmt->bindParam(':supplier_name', $supplier_name);
        $stmt->bindParam(':contact_number', $contact_number);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            $_SESSION['status'] = "Data updated successfully";
        } else {
            $_SESSION['status'] = "Data update failed: " . $stmt->errorInfo()[2];
        }
    } catch (Exception $e) {
        $_SESSION['status'] = "Data update failed: " . $e->getMessage();
    }
    header('Location: addsupplier.php');
    exit();
}
// Delete User
if (isset($_POST['click_delete_supp_btn'])) {
    $id = $_POST['supplier_id'];
    $delete_query = "DELETE FROM suppliers WHERE id = :id";
    $stmt = $conn->prepare($delete_query);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Data deleted successfully";
    } else {
        $_SESSION['status'] = "Data deletion failed: " . $stmt->errorInfo()[2];
    }
}
// Delete Supplier

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Insert inventory
if (isset($_POST['add_inventory'])) {
    $supplier = $_POST['supplier'];
    $product = $_POST['product_name']; // Change this to match form field name
    $package_quantity = (int)$_POST['package_quantity']; // Ensure this is an integer
    $measurement_per_package = (float)$_POST['measurement_per_package']; // Ensure this is a float
    $total_measurement = (float)$_POST['total_measurement']; // Ensure this is a float
    $unit = $_POST['unit'];
    

    // Check if product already exists
    $check_product_name_query = "SELECT * FROM inventory WHERE product_name = ?";
    $stmt = $conn->prepare($check_product_name_query);
    $stmt->execute([$product]);
    $check_product_result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single row

    if ($check_product_result) {
        // Product exists, update the quantity and total measurement
        $new_package_quantity = $check_product_result['package_quantity'] + $package_quantity;
        $existing_measurement_per_package = $check_product_result['measurement_per_package']; // Keep the existing measurement per package
        $new_total_measurement = $new_package_quantity * $existing_measurement_per_package; // Update total measurement

        $update_query = "UPDATE inventory SET package_quantity = ?, total_measurement = ? WHERE product_name = ?";
        $stmt = $conn->prepare($update_query);
        
        if ($stmt->execute([$new_package_quantity, $new_total_measurement, $product])) {
            $_SESSION['status'] = "Product quantity updated successfully!";
        } else {
            $_SESSION['status'] = "Error: " . $stmt->errorInfo()[2]; // Get the error message
        }
    } else {
        // Product does not exist, insert a new record
        $insert_query = "INSERT INTO inventory (supplier, product_name, package_quantity, measurement_per_package, total_measurement, unit) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        
        // Execute the statement with an array of values
        if ($stmt->execute([$supplier, $product, $package_quantity, $measurement_per_package, $total_measurement, $unit])) {
            $_SESSION['status'] = "Supplier Product added successfully!";
        } else {
            $_SESSION['status'] = "Error: " . $stmt->errorInfo()[2]; // Get the error message
        }
    }
    
    header("Location: inventoryManage.php");
    exit();
}


//view inventory
if (isset($_POST['click_view_inventory_btn'])) {
    $id = $_POST['inventory_id'];

    $fetch_query = "SELECT * FROM inventory WHERE id = ?";
    $stmt = $connection->prepare($fetch_query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $fetch_query_run = $stmt->get_result();

    if ($fetch_query_run->num_rows > 0) {
        while ($row = $fetch_query_run->fetch_assoc()) {
            echo '
            <h6>ID: ' . htmlspecialchars($row['id']) . '</h6>
            <h6>Supplier: ' . htmlspecialchars($row['supplier']) . '</h6>
            <h6>Product Name: ' . htmlspecialchars($row['product_name']) . '</h6>
            <h6>Package Quantity: ' . htmlspecialchars($row['package_quantity']) . '</h6>
            <h6>Measurement Per Package: ' . htmlspecialchars($row['measurement_per_package']) . '</h6>
            <h6>Total Measurement: ' . htmlspecialchars($row['total_measurement']) . '</h6>
            <h6>Unit: ' . htmlspecialchars($row['unit']) . '</h6>
            <h6>Expiration Date: ' . htmlspecialchars($row['Expiry_Date']) . '</h6>
            ';
        }
    } else {
        echo '<h4>No records found</h4>';
    }
}
//edit inventory
if (isset($_POST['inventory'])) {
    $supplier = $_POST['supplier'];
    $stmt = $connection->prepare("SELECT product_name FROM products WHERE supplier_name = :supplier");
    $stmt->bindParam(':supplier', $supplier);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $productOptions = '';
    if (count($products) > 0) {
        foreach ($products as $product) {
            $productOptions .= "<option value='" . htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8') . "</option>";
        }
    } else {
        $productOptions = "<option value=''>No products found</option>";
    }

    echo $productOptions;
}



// Update inventory
if (isset($_POST['update_inventory'])) {
    $id = $_POST['id']; // Ensure you retrieve the user ID
    $supplier = $_POST['supplier'];
    $product = $_POST['product_name'];
    $package_quantity = $_POST['package_quantity'];
    $measurement_per_package = $_POST['measurement_per_package'];
    $total_measurement = $_POST['total_measurement'];
    $category = $_POST['category'];
    $unit = $_POST['unit'];
    $Expiry_Date = $_POST['Expiry_Date'];


    // Prepare the update query
    $update_query = "UPDATE inventory SET supplier = '$supplier', product_name = '$product_name', package_quantity = '$package_quantity'
    , measurement_per_package = '$measurement_per_package' , total_measurement = '$total_measurement'
     , category = '$category'
      , unit = '$unit'
       , Expiry_Date = '$Expiry_Date' WHERE id = '$id'";

    // Execute the update query
    $update_query_run = mysqli_query($connection, $update_query);

    if ($update_query_run) {
        $_SESSION['status'] = "Data updated successfully";
        header('location: inventoryManage.php');
        exit();
    } else {
        $_SESSION['status'] = "Data update failed: " . mysqli_error($connection);
        header('location: inventoryManage.php');
        exit();
    }
}


//delete inventory
if (isset($_POST['click_delete_inventory_btn'])) {
    $id = $_POST['inventory_id'];
    $delete_query = "DELETE FROM inventory WHERE id='$id'";
    $delete_query_run = mysqli_query($connection, $delete_query);

    if ($delete_query_run) {
        $_SESSION['status'] = "Data updated successfully";
        header('location: inventoryManage.php');
        exit();
    } else {
        $_SESSION['status'] = "Data update failed: " . mysqli_error($connection);
        header('location: inventoryManage.php');
        exit();
    }

}
//////////////////////////////////////////////////////////////////////////////////////////////////////

 // Insert product
if (isset($_POST['add_product'])) {
    $product_name = htmlspecialchars($_POST['productname']);
    $price = floatval($_POST['price']);
    $category = htmlspecialchars($_POST['category']);
    $targetFilePath = '';

    // Check if image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "images/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        $newFileName = uniqid() . '_' . basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $newFileName;

        // Move uploaded file
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $_SESSION['status'] = "Error uploading file.";
            header('Location: addproduct.php');
            exit();
        }
    } else {
        $_SESSION['status'] = "Please upload an image.";
        header('Location: addproduct.php');
        exit();
    }

    try {
        // Prepare and execute the insert statement
        $stmt = $conn->prepare("INSERT INTO product (product_name, image, price, category) VALUES (:product_name, :image, :price, :category)");
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':image', $targetFilePath);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category', $category);

        if ($stmt->execute()) {
            $product_id = $conn->lastInsertId();
            if (isset($_POST['ingredient_name']) && is_array($_POST['ingredient_name'])) {
                $ingredientNames = $_POST['ingredient_name'];
                $quantities = $_POST['quantity'];
                $units = $_POST['unit'];

                $ingredientStmt = $conn->prepare("INSERT INTO product_ingredients_detail (product_id, ingredient_name, quantity, unit) VALUES (:product_id, :ingredient_name, :quantity, :unit)");

                foreach ($ingredientNames as $index => $ingredientName) {
                    $ingredientName = htmlspecialchars($ingredientName);
                    $quantity = floatval($quantities[$index]);
                    $unit = htmlspecialchars($units[$index]);

                    $ingredientStmt->bindParam(':product_id', $product_id);
                    $ingredientStmt->bindParam(':ingredient_name', $ingredientName);
                    $ingredientStmt->bindParam(':quantity', $quantity);
                    $ingredientStmt->bindParam(':unit', $unit);
                    $ingredientStmt->execute();
                }
            }
            $_SESSION['status'] = "Product added successfully.";
        } else {
            $_SESSION['status'] = "Error: " . implode(", ", $stmt->errorInfo());
        }
    } catch (PDOException $e) {
        $_SESSION['status'] = "Database error: " . $e->getMessage();
    }

    header('Location: addproduct.php');
    exit();
}

// View product
if (isset($_POST['click_view_product_btn'])) {
    $id = $_POST['product_id'];
    $stmt = $conn->prepare("SELECT * FROM product WHERE product_id = ?");
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Fetch ingredients for the product
        $ingredientStmt = $conn->prepare("SELECT * FROM product_ingredients_detail WHERE product_id = ?");
        $ingredientStmt->bindParam(1, $id, PDO::PARAM_INT);
        $ingredientStmt->execute();
        $ingredients = $ingredientStmt->fetchAll(PDO::FETCH_ASSOC);

        $result['ingredients'] = $ingredients;
        echo json_encode(['success' => true, 'data' => $result]);
    } 
    else {
        echo json_encode(['success' => false, 'message' => 'No records found']);
    }
}

if (isset($_POST['click_edit_product_btn'])) {
    $id = $_POST['product_id'];
    $stmt = $conn->prepare("SELECT * FROM product WHERE product_id = ?");
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Fetch ingredients for the product
        $ingredientStmt = $conn->prepare("SELECT * FROM product_ingredients_detail WHERE product_id = ?");
        $ingredientStmt->bindParam(1, $id, PDO::PARAM_INT);
        $ingredientStmt->execute();
        $ingredients = $ingredientStmt->fetchAll(PDO::FETCH_ASSOC);

        $result['ingredients'] = $ingredients;
        echo json_encode($result);
    } else {
        echo json_encode(['message' => 'No records found']);
    }
}

// Update product details
if (isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $product_name = htmlspecialchars($_POST['productname']);
    $price = floatval($_POST['price']);
    $category = htmlspecialchars($_POST['category']);
    $newFileName = null;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "images/";
        $newFileName = uniqid() . '_' . basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $newFileName;

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            echo json_encode(['success' => false, 'message' => 'Error uploading file.']);
            exit();
        }
    }

    try {
        // Prepare the update query
        $query = "UPDATE product SET product_name = ?, price = ?, category = ?";
        if ($newFileName) {
            $query .= ", image = ?";
        }
        $query .= " WHERE product_id = ?";

        $stmt = $conn->prepare($query);
        if ($newFileName) {
            $stmt->bindParam(1, $product_name);
            $stmt->bindParam(2, $price);
            $stmt->bindParam(3, $category);
            $stmt->bindParam(4, $newFileName);
            $stmt->bindParam(5, $product_id);
        } else {
            $stmt->bindParam(1, $product_name);
            $stmt->bindParam(2, $price);
            $stmt->bindParam(3, $category);
            $stmt->bindParam(4, $product_id);
        }
        $stmt->execute();

        // Update ingredients
        $ingredient_names = $_POST['ingredient_name'];
        $quantities = $_POST['quantity'];
        $units = $_POST['unit'];

        // Clear existing ingredients for the product
        $deleteStmt = $conn->prepare("DELETE FROM product_ingredients_detail WHERE product_id = ?");
        $deleteStmt->bindParam(1, $product_id, PDO::PARAM_INT);
        $deleteStmt->execute();

        // Insert new ingredients
        $insertStmt = $conn->prepare("INSERT INTO product_ingredients_detail (product_id, ingredient_name, quantity, unit) VALUES (?, ?, ?, ?)");
        foreach ($ingredient_names as $index => $ingredient_name) {
            $quantity = $quantities[$index];
            $unit = $units[$index];
            $insertStmt->execute([$product_id, $ingredient_name, $quantity, $unit]);
        }

        echo json_encode(['success' => true, 'message' => 'Product updated successfully.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database Error: ' . $e->getMessage()]);
    }
}

// Delete product
if (isset($_POST['click_delete_product_btn'])) {
    $id = $_POST['productid'];
    try {
        // First delete from product_ingredients_detail
        $ingredientStmt = $conn->prepare("DELETE FROM product_ingredients_detail WHERE product_id = ?");
        $ingredientStmt->bindParam(1, $id, PDO::PARAM_INT);
        $ingredientStmt->execute();

        // Then delete from product
        $stmt = $conn->prepare("DELETE FROM product WHERE product_id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
            exit();
        } else {
            echo json_encode(['success' => false, ' message' => 'Delete failed']);
            exit();
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database Error: ' . $e->getMessage()]);
        exit();
    }
}
//////////////////////////////////////////////////////////////////////////////////

//insert supplier_products
if (isset($_POST['add_supp_product'])) {
    // Retrieve form data
    $supplier = $_POST['supplier'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity']; // Assuming you're adding this field
    $unit = $_POST['unit']; // Assuming you're adding this field
    

    // Connect to the database
    include('connection.php');

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO supplier_products (supplier, product_name, price, quantity, unit) VALUES (:supplier, :product_name, :price, :quantity, :unit)");

    // Bind parameters
    $stmt->bindParam(':supplier', $supplier);
    $stmt->bindParam(':product_name', $product_name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':unit', $unit);
   

    // Execute the statement
    try {
        $stmt->execute();
        $_SESSION['status'] = "Product added successfully!";
    } catch (PDOException $e) {
        $_SESSION['status'] = "Error: " . $e->getMessage();
    }

    // Close the database connection
    $conn = null;

    // Redirect back to the form page
    header("Location: addsupplier_product.php"); // Change this to your form page
    exit();
}
//view supplier_products
if (isset($_POST['click_view_supplier_product_btn'])) {
    $id = $_POST['supplier_product_id'];

    $fetch_query = "SELECT * FROM supplier_products WHERE id = '$id'";
    $fetch_query_run = mysqli_query($connection, $fetch_query);


    if (mysqli_num_rows($fetch_query_run) > 0) {

        while ($row = mysqli_fetch_array($fetch_query_run)) {
            echo '
        <h6>ID: ' . $row['id'] . '</h6>
        <h6>Supplier: ' . $row['supplier'] . '</h6>
        <h6>Product Name: ' . $row['product_name'] . '</h6>
        <h6>Proce: ' . $row['price'] . '</h6>
        <h6>Category: ' . $row['category'] . '</h6>
         
        ';

        }
    } else {
        echo '<h4>no records found</h4>';

    }
}

//edit supplier_products
if (isset($_POST['click_edit_supplier_products_btn'])) {
    $id = $_POST['supplier_product_id'];
    $arrayresult = [];

    $fetch_query = "SELECT * FROM supplier_products WHERE id = '$id'";
    $fetch_query_run = mysqli_query($conn, $fetch_query);


    if (mysqli_num_rows($fetch_query_run) > 0) {

        while ($row = mysqli_fetch_array($fetch_query_run)) {

            array_push($arrayresult, $row);
            header('content-type: application/json');
            echo json_encode($arrayresult);

        }
    } else {
        echo '<h4>no records found</h4>';

    }
}

// Update supplier_products
if (isset($_POST['update_supplier_product'])) {
    $id = $_POST['id']; // Ensure you retrieve the user ID
    $supplier = $_POST['supplier'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    // Prepare the update query
    $update_query = "UPDATE supplier_products SET supplier = '$supplier', product_name = '$product_name', price = '$price', category = '$category' WHERE id = '$id'";

    // Execute the update query
    $update_query_run = mysqli_query($connection, $update_query);

    if ($update_query_run) {
        $_SESSION['status'] = "Data updated successfully";
        header('location: addsupplier_product.php');
        exit();
    } else {
        $_SESSION['status'] = "Data update failed: " . mysqli_error($connection);
        header('location: addsupplier_product.php');
        exit();
    }
}

//delete supplier_products


//delete inventory
if (isset($_POST['click_delete_supplier_product_btn'])) {
    $id = $_POST['supplier_product_id'];
    $delete_query = "DELETE FROM supplier_products WHERE id='$id'";
    $delete_query_run = mysqli_query($conn, $delete_query);

    if ($delete_query_run) {
        $_SESSION['status'] = "Data updated successfully";
        header('location: addsupplier_product.php');
        exit();
    } else {
        $_SESSION['status'] = "Data update failed: " . mysqli_error($connection);
        header('location: addsupplier_product.php');
        exit();
    }

}
// Assuming the database connection is already included and initialized





