<?php
include 'db_connect.php';

$message = "";
$message_color = "";

// Fetch all active medicines
$medicines = pg_query($conn, "SELECT * FROM medicine WHERE is_active = TRUE");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medicine_id = $_POST['medicine_id'];
    $quantity = $_POST['quantity'];

    // Check stock
    $check = pg_query($conn, "SELECT quantity FROM medicine WHERE medicine_id=$medicine_id");
    $stock = pg_fetch_assoc($check)['quantity'];

    if ($quantity <= $stock) {
        // Insert into sale
        $sale_query = "INSERT INTO sales DEFAULT VALUES RETURNING sale_id";
        $sale_result = pg_query($conn, $sale_query);
        $sale_id = pg_fetch_assoc($sale_result)['sale_id'];

        // Insert into sale_details
        $detail_query = "INSERT INTO sale_details (sale_id, medicine_id, quantity) VALUES ($sale_id, $medicine_id, $quantity)";
        pg_query($conn, $detail_query);

        // Update stock
        pg_query($conn, "UPDATE medicine SET quantity = quantity - $quantity WHERE medicine_id=$medicine_id");

        $message = "✅ Sale recorded successfully!";
        $message_color = "green";
    } else {
        $message = "⚠️ Not enough stock!";
        $message_color = "orange";
    }
}

pg_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Sale</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Add Sale</h2>
<?php if (!empty($message)) echo "<p class='message' style='color:$message_color;'>$message</p>"; ?>

<form action="" method="POST">
    <div>
        <label>Medicine:</label>
        <select name="medicine_id">
            <?php while ($med = pg_fetch_assoc($medicines)) { ?>
                <option value="<?php echo $med['medicine_id']; ?>">
                    <?php echo $med['medicine_name'] . " (Stock: " . $med['quantity'] . ")"; ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <div>
        <label>Quantity:</label>
        <input type="number" name="quantity" required>
    </div>
    <div>
        <input type="submit" value="Add Sale">
    </div>
</form>

<br>
<a href="view_sales.php">View Sales</a>
</body>
</html>
