<?php
$host = "localhost";
$port = "5432";
$dbname = "pharmacydb";
$user = "postgres";
$password = "your_password_here";

$conn = pg_connect("host=localhost port=5432 dbname=Pharmacy_DB user=postgres password=12345");

if (!$conn) {
    die("❌ Connection failed: " . pg_last_error());
} else {
    echo "✅ Connected successfully to PostgreSQL!";
}
?>
