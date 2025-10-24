<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

$message = "";
$message_color = "";

// ... (ALL YOUR PHP LOGIC FOR POSTING DATA IS HERE) ...
// ... (I AM NOT SHOWING IT ALL TO SAVE SPACE, BUT IT IS THE SAME) ...
$medicines = mysqli_query($conn, "SELECT id, name, quantity, price FROM medicine WHERE quantity > 0");
if (!$medicines) {
    die("Error fetching medicines: " . mysqli_error($conn));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medicine_id = $_POST['medicine_id'];
    $quantity = $_POST['quantity'];

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
            $total_price = $price * $quantity;
            $stmt_insert = mysqli_prepare($conn, "INSERT INTO sale (medicine_id, quantity_sold, total_price) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt_insert, "iid", $medicine_id, $quantity, $total_price);
            mysqli_stmt_execute($stmt_insert);
            mysqli_stmt_close($stmt_insert);

            $stmt_update = mysqli_prepare($conn, "UPDATE medicine SET quantity = quantity - ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt_update, "ii", $quantity, $medicine_id);
            mysqli_stmt_execute($stmt_update);
            mysqli_stmt_close($stmt_update);

            $message = "✅ Sale recorded successfully!";
            $message_color = "green";
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Sale</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <header>
            <h1>Add Sale</h1>
        </header>

        <main class="content-wrapper">
            
            <?php if(!empty($message)) echo "<p class='message $message_color'>$message</p>"; ?>

            <form class.="form-layout" method="POST">
                <div class="form-group">
                    <label for="med_select">Medicine:</label>
                    <select id="med_select" name="medicine_id">
                        <?php while($med = mysqli_fetch_assoc($medicines)) { ?>
                        <option value="<?php echo $med['id']; ?>">
                            <?php echo $med['name'] . " (Stock: " . $med['quantity'] . ")"; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="sale_qty">Quantity:</label>
                    <input type="number" id="sale_qty" name="quantity" required min="1">
                </div>

                <div>
                    <input type="submit" value="Add Sale" class="btn">
                </div>
            </form>

            <nav class="page-nav">
                <a href="view_sales.php">View Sales</a>
                <a href="index.php">Back to Home</a>
            </nav>
        </main>
    </div>

</body>
</html>
<?php 
if (isset($conn)) {
    mysqli_close($conn);
} 
?>