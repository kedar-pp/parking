<?php
include '../includes/dbconn.php'; // Database connection
session_start();

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to enter a vehicle.");
}

$user_id = $_SESSION['user_id']; // Logged-in user ID
$vehicle_no = trim($_POST['vehicle_no']);

if (empty($vehicle_no)) {
    die("Vehicle number is required.");
}

// Check if vehicle is already parked (not exited)
$checkQuery = "SELECT * FROM vehicle_log WHERE vehicle_no = ? AND status = 'IN'";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bind_param("s", $vehicle_no);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    die("This vehicle is already parked!");
}

// Insert vehicle entry
$sql = "INSERT INTO vehicle_log (user_id, vehicle_no) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $vehicle_no);

if ($stmt->execute()) {
    echo "<script>alert('Vehicle Entry Recorded!'); window.location.href='dashboard.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}
?>
