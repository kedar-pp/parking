<?php
session_start();
include("../includes/dbconn.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["id"])) {
    echo "Invalid request.";
    exit();
}

$log_id = $_GET["id"];
$query = "SELECT * FROM vehicle_logs WHERE id = ? AND payment_status = 'Paid'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $log_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "No invoice found.";
    exit();
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
</head>
<body>
    <h2>Parking Invoice</h2>
    <p><strong>Vehicle No:</strong> <?php echo $row["vehicle_no"]; ?></p>
    <p><strong>Entry Time:</strong> <?php echo $row["entry_time"]; ?></p>
    <p><strong>Exit Time:</strong> <?php echo $row["exit_time"]; ?></p>
    <p><strong>Total Amount:</strong> ₹<?php echo number_format($row["amount"], 2); ?></p>
    <p><strong>Payment Status:</strong> <?php echo $row["payment_status"]; ?></p>

    <button onclick="window.print()">Print Invoice</button>
</body>
</html>
