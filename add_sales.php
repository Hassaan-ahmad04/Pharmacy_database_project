<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

$message = "";
$message_color = "";

// 1. FIX: Changed column 'id' and 'name'
$medicines = mysqli_query($conn, "SELECT id, name, quantity, price FROM medicine WHERE quantity > 0");
if (!$medicines) {
    die("Error fetching medicines: " . mysqli_error($conn));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medicine_id = $_POST['medicine_id'];
    $quantity = $_POST['quantity'];

    // 2. FIX: Fetch stock AND price for calculation. Use 'id'.
    // Use prepared statements for security
    $stmt = mysqli_prepare($conn, "SELECT quantity, price FROM medicine WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $medicine_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $medicine_data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($medicine_data) {
        $stock = $medicine_data['quantity'];
        $price = $medicine_data['price'];

        if ($quantity <= $stock) {
            
            // 3. FIX: Calculate total_price (required by your 'sale' table)
            $total_price = $price * $quantity;

            // 4. FIX: Removed old broken INSERTs. 
            // This now inserts directly into your 'sale' table as required.
            $stmt_insert = mysqli_prepare($conn, "INSERT INTO sale (medicine_id, quantity_sold, total_price) VALUES (?, ?, ?)");
            // 'iid' = integer, integer, double
            mysqli_stmt_bind_param($stmt_insert, "iid", $medicine_id, $quantity, $total_price);
            mysqli_stmt_execute($stmt_insert);
            mysqli_stmt_close($stmt_insert);

            // 5. FIX: Update stock using correct column 'id'
            $stmt_update = mysqli_prepare($conn, "UPDATE medicine SET quantity = quantity - ? WHERE id = ?");
            // 'ii' = integer, integer
            mysqli_stmt_bind_param($stmt_update, "ii", $quantity, $medicine_id);
            mysqli_stmt_execute($stmt_update);
            mysqli_stmt_close($stmt_update);

            $message = "✅ Sale recorded successfully!";
            $message_color = "green";
            // Refresh medicine list after update
            $medicines = mysqli_query($conn, "SELECT id, name, quantity, price FROM medicine WHERE quantity > 0");

        } else {
            $message = "⚠️ Not enough stock!";
            $message_color = "orange";
        }
    } else {
        $message = "❌ Invalid medicine selected!";
        $message_color = "red";
    }
}
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
            <option value="<?php echo $med['id']; ?>">
                <?php echo $med['name'] . " (Stock: " . $med['quantity'] . ")"; ?>
            </option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label>Quantity:</label>
        <input type="number" name="quantity" required min="1">
    </div>

    <div>
        <input type="submit" value="Add Sale">
    </div>
</form>

<a href="view_sales.php">View Sales</a>
</body>
</html>
<?php 
// Close connection at the end of the file
if (isset($conn)) {
    mysqli_close($conn);
} 
?>