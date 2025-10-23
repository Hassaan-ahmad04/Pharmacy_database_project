<?php
include 'db_connect.php';

$id = $_GET['id'] ?? null;
$message = "";
$message_color = "";

if (!$id) {
    die("Invalid Medicine ID");
}

// Fetch current data
$res = mysqli_query($conn, "SELECT * FROM medicine WHERE medicine_id=$id");
$medicine = mysqli_fetch_assoc($res);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medicine_name = $_POST['medicine_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $query = "UPDATE medicine SET medicine_name='$medicine_name', price=$price, quantity=$quantity 
              WHERE medicine_id=$id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $message = "✅ Medicine updated successfully!";
        $message_color = "green";
    } else {
        $message = "❌ Error: " . mysqli_error($conn);
        $message_color = "red";
    }

    // Refresh data
    $res = mysqli_query($conn, "SELECT * FROM medicine WHERE medicine_id=$id");
    $medicine = mysqli_fetch_assoc($res);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Medicine</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Update Medicine</h2>

<?php if(!empty($message)) echo "<p style='color:$message_color;'>$message</p>"; ?>

<form method="POST">
    <div class="form-group">
        <label>Medicine Name:</label>
        <input type="text" name="medicine_name" value="<?php echo $medicine['medicine_name']; ?>" required>
    </div>

    <div class="form-group">
        <label>Price:</label>
        <input type="number" name="price" value="<?php echo $medicine['price']; ?>" required>
    </div>

    <div class="form-group">
        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?php echo $medicine['quantity']; ?>" required>
    </div>

    <div>
        <input type="submit" value="Update Medicine">
    </div>
</form>

<a href="view_medicine.php">Back to List</a>
</body>
</html>

<?php mysqli_close($conn); ?>
