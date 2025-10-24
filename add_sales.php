<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

$message = "";
$message_color = "";

// Fetch medicines
$medicines = mysqli_query($conn, "SELECT * FROM medicine WHERE quantity>0");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medicine_id = $_POST['medicine_id'];
    $quantity = $_POST['quantity'];

    // Check stock
    $check = mysqli_query($conn, "SELECT quantity FROM medicine WHERE medicine_id=$medicine_id");
    $stock = mysqli_fetch_assoc($check)['quantity'];

    if ($quantity <= $stock) {
        // Insert into sale
        mysqli_query($conn, "INSERT INTO sale () VALUES ()");
        $sale_id = mysqli_insert_id($conn);

        // Insert into sale_details
        mysqli_query($conn, "INSERT INTO sale_details (sale_id, medicine_id, quantity) VALUES ($sale_id, $medicine_id, $quantity)");

        // Update stock
        mysqli_query($conn, "UPDATE medicine SET quantity = quantity - $quantity WHERE medicine_id=$medicine_id");

        $message = "✅ Sale recorded successfully!";
        $message_color = "green";
    } else {
        $message = "⚠️ Not enough stock!";
        $message_color = "orange";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Sale</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Add Sale</h2>
<?php if(!empty($message)) echo "<p style='color:$message_color;'>$message</p>"; ?>

<form method="POST">
    <div class="form-group">
        <label>Medicine:</label>
        <select name="medicine_id">
            <?php while($med = mysqli_fetch_assoc($medicines)) { ?>
            <option value="<?php echo $med['medicine_id']; ?>">
                <?php echo $med['medicine_name'] . " (Stock: " . $med['quantity'] . ")"; ?>
            </option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label>Quantity:</label>
        <input type="number" name="quantity" required>
    </div>

    <div>
        <input type="submit" value="Add Sale">
    </div>
</form>

<a href="view_sales.php">View Sales</a>
</body>
</html>
