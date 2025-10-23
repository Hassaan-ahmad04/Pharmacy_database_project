<?php
include 'db_connect.php';

$message = ""; 
$message_color = ""; 

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medicine_name = $_POST['medicine_name'] ?? "";
    $price = $_POST['price'] ?? "";
    $quantity = $_POST['quantity'] ?? "";

    if ($medicine_name && $price && $quantity) {
        $query = "INSERT INTO medicine (medicine_name, price, quantity)
                  VALUES ('$medicine_name', $price, $quantity)";
        $result = pg_query($conn, $query);

        if ($result) {
            $message = "✅ Medicine added successfully!";
            $message_color = "green";
        } else {
            $message = "❌ Error: " . pg_last_error($conn);
            $message_color = "red";
        }
    } else {
        $message = "⚠️ All fields are required!";
        $message_color = "orange";
    }
}

// Fetch all medicines for display
$medicines_result = pg_query($conn, "SELECT * FROM medicine ORDER BY medicine_id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Medicine</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Add New Medicine</h2>

    <!-- Form -->
    <form action="" method="POST">
        <div>
            <label>Medicine Name:</label>
            <input type="text" name="medicine_name" required>
        </div>

        <div>
            <label>Price:</label>
            <input type="number" name="price" required>
        </div>

        <div>
            <label>Quantity:</label>
            <input type="number" name="quantity" required>
        </div>

        <div>
            <input type="submit" value="Add Medicine">
        </div>
    </form>

    <!-- Success/Error Message -->
    <?php 
    if (!empty($message)) {
        echo "<p style='color:$message_color;'>$message</p>";
    }
    ?>

    <!-- Display all medicines -->
    <h2>All Medicines</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Actions</th>
        </tr>
        <?php while($row = pg_fetch_assoc($medicines_result)) { ?>
        <tr>
            <td><?php echo $row['medicine_id']; ?></td>
            <td><?php echo $row['medicine_name']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td>
                <a class="button" href="update_medicine.php?id=<?php echo $row['medicine_id']; ?>">Edit</a>
                <a class="button delete" href="delete_medicine.php?id=<?php echo $row['medicine_id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>

<?php pg_close($conn); ?>
</body>
</html>
