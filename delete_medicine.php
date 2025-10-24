<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

$id = $_GET['id'] ?? null;

if ($id) {
    // --- START OF FIX ---
    // Use prepared statements to prevent SQL Injection
    
    $query = "DELETE FROM medicine WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    // 'i' means we are binding an integer
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    $result = mysqli_stmt_execute($stmt);
    // --- END OF FIX ---

    if ($result) {
        // Success: Redirect back to the list
        header("Location: view_medicine.php");
        exit();
    } else {
        // Failed: Show an error
        echo "❌ Error: "."An error occurred while trying to delete the record.";
        // echo "❌ Error: " . mysqli_stmt_error($stmt); // For debugging
    }
    
    mysqli_stmt_close($stmt); // Close the statement
    
} else {
    echo "Invalid Medicine ID.";
}

mysqli_close($conn); // Close the database connection
?>