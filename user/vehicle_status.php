<?php
include '../includes/dbconn.php';

$sql = "SELECT * FROM vehicle_log WHERE status = 'IN'";
$result = $conn->query($sql);

echo "<h3>Vehicle Details</h3>";
while ($row = $result->fetch_assoc()) {
    echo "Vehicle No: " . $row['vehicle_no'] . " | Entry Time: " . $row['entry_time'] . "<br>";
}
?>
