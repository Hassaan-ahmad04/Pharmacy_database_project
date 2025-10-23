<?php
include 'db_connect.php';

$message = "";
$message_color = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medicine_name = $_POST['medicine_name'] ?? "";
    $price = $_POST['price'] ?? "";
    $quantity = $_POST['quantity'] ?? "";

    if ($medicine_name && $price && $quantity) {
        $query = "INSERT INTO medicine (medicine_name, price, quantity) 
                  VALUES ('$medicine_name', $price, $quantity)";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $message = "✅ Medicine added successfully!";
            $message_color = "green";
        } else {
            $message = "❌ Error: " . mysqli_error($conn);
            $message_color = "red";
        }
    } else {
        $message = "⚠️ All fields are required!";
        $message_color = "orange";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Medicine</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Add New Medicine</h2>

<form action="" method="POST">
    <div class="form-group">
        <label>Medicine Name:</label>
        <input type="text" name="medicine_name" required>
    </div>

    <div class="form-group">
        <label>Price:</label>
        <input type="number" name="price" required>
    </div>

    <div class="form-group">
        <label>Quantity:</label>
        <input type="number" name="quantity" required>
    </div>

    <div>
        <input type="submit" value="Add Medicine">
    </div>
</form>

<?php if(!empty($message)) echo "<p style='color:$message_color;'>$message</p>"; ?>

<a href="view_medicine.php">View Medicines</a>
</body>
</html>
