<?php
session_start();
include('connection.php');
// Redirect to dashboard if already logged in
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

// Connect to database


// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['login_btn'])) {
    // Check if username and password are set
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username']; // No need to escape with PDO
        $password = $_POST['password']; // Get the plain password

        // Prepare and execute the SQL statement
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            // Verify the password
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                header("Location: dashboard.php"); // Redirect to dashboard
                exit();
            } else {
                $error = "Username or Password incorrect";
            }
        } else {
            $error = "Username or Password incorrect";
        }
    } else {
        $error = "Please enter both username and password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | The Good Shot Coffee Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="login.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- Font Awesome for eye icon -->
</head>
<body>
<div>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($error); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
</div>

<div class="container d-flex justify-content-center align-items-center shadow bg-light custom-container h-90">
    <div class="col-md-6 left-box rounded-4 d-flex justify-content-center align-items-center custom-left-box me-3">
        <img src="images/Logo.jpg" alt="" class="login-logo">
    </div>

    <div class="col-md-6 right-box justify-content-center align-items-center">
        <header class="mt-1">
            <p class="login-name">Login</p>
        </header>
        <form action="index.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Enter Username" required>
            </div>
            <div class="mb-3 password-container">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter Password" required>
                <i class="fas fa-eye show-password-icon" id="togglePassword" style="cursor: pointer;"></i>
            </div>
            <div class="submit-btn mt-5">
                <button type="submit" name="login_btn" class="btn custom-btn-login">Login</button>
            </div>
        </form>
    </div>
</div>
<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.querySelector('input[name="password"]');

    togglePassword.addEventListener('click', function () {
        const isPassword = passwordInput.getAttribute('type') === 'password';
        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

        this.classList.toggle('fa-eye');
        this.classList.toggle('fa -eye-slash'); 
    });
</script>
</body>
</html>     