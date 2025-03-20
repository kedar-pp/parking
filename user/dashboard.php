<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: register.php");
    exit();
}
// session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
</head>
<body>
<h1>Welcome, <?php echo $_SESSION["user_name"]; ?>!</h1>
    
    
<h2>Welcome to Vehicle Parking System</h2>

<!-- Vehicle Entry Form -->
<form action="vehicle_entry.php" method="POST">
    <label>Enter Vehicle No:</label>
    <input type="text" name="vehicle_no" required>
    <button type="submit">Park Vehicle</button>
</form>

<!-- Vehicle Exit Form -->
<form action="vehicle_exit.php" method="POST">
    <label>Exit Vehicle No:</label>
    <input type="text" name="vehicle_no" required>
    <button type="submit">Exit Parking</button>
</form>
<!-- <p align="right">
    <a href="make_payment.php">Payment</a>
</p> -->
<!-- Display Currently Parked Vehicles -->
<?php include 'vehicle_status.php'; ?>
    <a href="logout.php">Logout</a>
    
</body>
</html>


