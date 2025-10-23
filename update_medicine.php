<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db_connect.php';
?>

<?php
include 'db_connect.php';
$message = "";
$message_color = "";

// Get medicine ID from URL
$id = $_GET['id'] ?? '';

if (!$id) {
    die("Invalid medicine ID!");
}

// Fetch current medicine data
$result = pg_query($conn, "SELECT * FROM medicine WHERE medicine_id=$id");
$medicine = pg_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medicine_name = $_POST['medicine_name'] ?? "";
    $price = $_POST['price'] ?? "";
    $quantity = $_POST['quantity'] ?? "";

    if ($medicine_name && $price && $quantity) {
        $update = "UPDATE medicine 
                   SET medicine_name='$medicine_name', price=$price, quantity=$quantity 
                   WHERE medicine_id=$id";
        $res = pg_query($conn, $update);
        if ($res) {
            header("Location: add_medicine.php"); // Redirect back
            exit();
        } else {
            $message = "❌ Error: " . pg_last_error($conn);
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
    <title>Update Medicine</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Update Medicine</h2>

    <?php if ($message) echo "<p style='color:$message_color;'>$message</p>"; ?>

    <form action="" method="POST">
        <div>
            <label>Medicine Name:</label>
            <input type="text" name="medicine_name" value="<?php echo $medicine['medicine_name']; ?>" required>
        </div>

        <div>
            <label>Price:</label>
            <input type="number" name="price" value="<?php echo $medicine['price']; ?>" required>
        </div>

        <div>
            <label>Quantity:</label>
            <input type="number" name="quantity" value="<?php echo $medicine['quantity']; ?>" required>
        </div>

        <div>
            <input type="submit" value="Update Medicine">
        </div>
    </form>
</body>
</html>

<?php pg_close($conn); ?>