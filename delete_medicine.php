<?php
include 'db_connect.php';

$id = $_GET['id'] ?? '';

if (!$id) {
    die("Invalid medicine ID!");
}

// Soft delete: mark medicine as inactive
$result = pg_query($conn, "UPDATE medicine SET is_active = FALSE WHERE medicine_id = $id");

if ($result) {
    // Redirect back to medicine list
    header("Location: view_medicine.php"); // ya add_medicine.php jahan list show hoti ho
    exit();
} else {
    echo "❌ Error: " . pg_last_error($conn);
}

pg_close($conn);
?>
