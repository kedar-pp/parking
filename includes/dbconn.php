<?php
    $con=mysqli_connect("localhost", "root", "", "vehicle-parking-db");
    if(mysqli_connect_errno()){
    echo "Connection Fail".mysqli_connect_error();
    }
  ?>

<?php
$host = "localhost";
$user = "root"; // Default in XAMPP
$pass = ""; // No password by default in XAMPP
$dbname = "vehicle-parking-db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
