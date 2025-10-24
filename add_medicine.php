<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

$message = "";
$message_color = "";

// ... (ALL YOUR PHP LOGIC FOR POSTING DATA IS HERE) ...
// ... (I AM NOT SHOWING IT ALL TO SAVE SPACE, BUT IT IS THE SAME) ...
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medicine_name = $_POST['medicine_name'] ?? "";
    $price = $_POST['price'] ?? "";
    $quantity = $_POST['quantity'] ?? "";

    if ($medicine_name && $price && $quantity) {
        $query = "INSERT INTO medicine (name, price, quantity) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sdi", $medicine_name, $price, $quantity);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $message = "✅ Medicine added successfully!";
            $message_color = "green";
        } else {
            $message = "❌ Error: " . mysqli_stmt_error($stmt);
            $message_color = "red";
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = "⚠️ All fields are required!";
        $message_color = "orange";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Medicine</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <header>
            <h1>Add New Medicine</h1>
        </header>

        <main class="content-wrapper">
            
            <?php if(!empty($message)) echo "<p class='message $message_color'>$message</p>"; ?>

            <form class="form-layout" action="" method="POST">
                <div class="form-group">
                    <label for="med_name">Medicine Name:</label>
                    <input type="text" id="med_name" name="medicine_name" required>
                </div>

                <div class="form-group">
                    <label for="med_price">Price:</label>
                    <input type="number" id="med_price" name="price" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="med_qty">Quantity:</label>
                    <input type="number" id="med_qty" name="quantity" required>
                </div>

                <div>
                    <input type="submit" value="Add Medicine" class="btn">
                </div>
            </form>

            <nav class="page-nav">
                <a href="view_medicine.php">View Medicines</a>
                <a href="index.php">Back to Home</a>
            </nav>
        </main>
    </div>

</body>
</html>