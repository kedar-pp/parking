<?php
session_start();
include("../includes/dbconn.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$rate_per_hour = 50; // Set your rate per hour

// Fetch the latest unpaid parking session
$query = "SELECT * FROM vehicle_logs WHERE user_id = ? AND payment_status = 'Pending' ORDER BY entry_time DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $entry_time = strtotime($row["entry_time"]);
    $exit_time = strtotime($row["exit_time"]);

    if ($exit_time) {
        $hours = ceil(($exit_time - $entry_time) / 3600);
        $amount = $hours * $rate_per_hour;
    } else {
        echo "Please exit your vehicle first.";
        exit();
    }
} else {
    echo "No pending payments found.";
    exit();
}

// Process payment on form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $update_query = "UPDATE vehicle_logs SET amount = ?, payment_status = 'Paid' WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("di", $amount, $row["id"]);

    if ($update_stmt->execute()) {
        header("Location: invoice.php?id=" . $row["id"]);
        exit();
    } else {
        echo "Payment failed.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Make Payment</title>
</head>
<body>
    <h2>Payment Details</h2>
    <p>Vehicle No: <?php echo $row["vehicle_no"]; ?></p>
    <p>Entry Time: <?php echo $row["entry_time"]; ?></p>
    <p>Exit Time: <?php echo $row["exit_time"]; ?></p>
    <p>Total Amount: ₹<?php echo number_format($amount, 2); ?></p>

    <form method="POST">
        <button type="submit">Pay Now</button>
    </form>
</body>
</html>
