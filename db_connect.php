<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$url = getenv("DATABASE_URL");

if (!$url) {
    die("❌ DATABASE_URL not found. Check Railway variable settings.");
}

$components = parse_url($url);

$conn = new mysqli(
    $components['host'],
    $components['user'],
    $components['pass'],
    ltrim($components['path'], '/'),
    $components['port']
);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
?>
