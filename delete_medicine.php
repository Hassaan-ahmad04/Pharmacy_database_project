<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $result = mysqli_query($conn, "DELETE FROM medicine WHERE medicine_id=$id");

    if ($result) {
        header("Location: view_medicine.php");
        exit();
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }
}
?>
