<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

$id = $_GET['id'] ?? null;
$message = "";
$message_color = "";

if (!$id) {
    die("Invalid Medicine ID");
}

// --- SECURE DATA FETCHING ---
// Use prepared statements to get initial data
$stmt = mysqli_prepare($conn, "SELECT * FROM medicine WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$medicine = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

if (!$medicine) {
    die("Medicine not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. FIX: Read from the correct form input name
    $medicine_name = $_POST['medicine_name']; // Changed from 'name' to 'medicine_name' to match form
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // --- SECURE UPDATE ---
    // 2. FIX: SQL column is 'name'. Use prepared statements
    $query = "UPDATE medicine SET name = ?, price = ?, quantity = ? WHERE id = ?";
    
    $stmt_update = mysqli_prepare($conn, $query);
    // 'sdii' = string, double, integer, integer
    mysqli_stmt_bind_param($stmt_update, "sdii", $medicine_name, $price, $quantity, $id);
    $result = mysqli_stmt_execute($stmt_update);

    if ($result) {
        $message = "✅ Medicine updated successfully!";
        $message_color = "green";
    } else {
        $message = "❌ Error: " . mysqli_stmt_error($stmt_update);
        $message_color = "red";
    }
    mysqli_stmt_close($stmt_update);

    // --- SECURE DATA REFRESH ---
    // 3. FIX: Use 'id' (and prepared statement)
    $stmt_refresh = mysqli_prepare($conn, "SELECT * FROM medicine WHERE id = ?");
    mysqli_stmt_bind_param($stmt_refresh, "i", $id);
    mysqli_stmt_execute($stmt_refresh);
    $res = mysqli_stmt_get_result($stmt_refresh);
    $medicine = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt_refresh);
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
        <input type="text" name="medicine_name" value="<?php echo htmlspecialchars($medicine['name']); ?>" required>
    </div>

    <div class="form-group">
        <label>Price:</label>
        <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($medicine['price']); ?>" required>
    </div>

    <div class="form-group">
        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?php echo htmlspecialchars($medicine['quantity']); ?>" required>
    </div>

    <div>
        <input type="submit" value="Update Medicine">
    </div>
</form>

<a href="view_medicine.php">Back to List</a>
</body>
</html>

<?php mysqli_close($conn); ?>