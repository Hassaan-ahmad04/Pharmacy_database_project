<?php
$host = "localhost";
$dbname = "pharmacy_db"; // MySQL database name
$user = "root";           // your MySQL username
$pass = "";               // your MySQL password

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
