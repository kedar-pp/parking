<?php
include '../includes/dbconn.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_no = trim($_POST['vehicle_no']);

    if (empty($vehicle_no)) {
        die("Vehicle number is required.");
    }

    // Update vehicle exit details
    $sql = "UPDATE vehicle_log SET exit_time = NOW(), status = 'OUT' WHERE vehicle_no = ? AND status = 'IN'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $vehicle_no);

    if ($stmt->execute()) {
        echo "<script>alert('Vehicle Exit Recorded!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
