<?php
session_start();
include('../includes/dbconn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        die("<script>alert('Both fields are required!'); window.location.href='login.php';</script>");
    }

    $sql = "SELECT id, name, password FROM users WHERE email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            echo "<script>alert('Login successful!'); window.location.href='dashboard.php';</script>";
            exit();
        } else {
            die("<script>alert('Invalid email or password.'); window.location.href='login.php';</script>");
        }
        // else {
        //     die("<script>alert('Enter email and password.'); window.location.href='register.php';</script>");
        // }
    } else {
        die("<script>alert('User not found. Please register first.'); window.location.href='register.html';</script>");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin: 50px; }
        form { display: inline-block; text-align: left; }
        input { display: block; margin: 10px 0; padding: 8px; width: 250px; }
        button { padding: 10px 15px; background: blue; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
