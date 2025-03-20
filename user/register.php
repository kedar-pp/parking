<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('../includes/dbconn.php'); // Ensure this file has the correct database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $vehicle_no = isset($_POST['vehicle_no']) ? trim($_POST['vehicle_no']) : '';

    // Validate input
    if (empty($name) || empty($email) || empty($password) || empty($phone) || empty($vehicle_no)) {
        die("<script>alert('All fields are required!'); window.location.href='register.html';</script>");
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check database connection
    if (!$con) {
        die("<script>alert('Database connection failed!'); window.location.href='register.html';</script>");
    }

    // Check if the email already exists
    $check_query = "SELECT email FROM users WHERE email = ?";
    $check_stmt = $con->prepare($check_query);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        die("<script>alert('Email already registered! Try logging in.'); window.location.href='login.php';</script>");
    }

    // Insert user into the database
    $sql = "INSERT INTO users (name, email, password, phone, vehicle_no) VALUES (?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssss", $name, $email, $hashed_password, $phone, $vehicle_no);
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Redirecting to login page...'); window.location.href='login.php';</script>";
            exit();
        } else {
            die("<script>alert('Error in registration. Please try again.'); window.location.href='register.html';</script>");
        }
    } else {
        die("<script>alert('Database error: Unable to prepare query.'); window.location.href='register.html';</script>");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin: 50px; }
        form { display: inline-block; text-align: left; }
        input { display: block; margin: 10px 0; padding: 8px; width: 250px; }
        button { padding: 10px 15px; background: blue; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

    <h2>Register</h2>
    <form action="register.php" method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="text" name="vehicle_no" placeholder="Vehicle Number" required>
        <button type="submit">Register</button>
    </form>
    <div class="text-right">
    		 <a href="login.php">Login</a>
		</div>

</body>
</html>
