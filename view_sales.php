<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

// --- START OF FIX ---
// This query now matches your database schema.
// 1. It joins 'sale' with 'medicine' (not 'sale_details').
// 2. It uses the correct column names: 's.id', 'm.name', 's.quantity_sold'.
// 3. It uses the correct join condition: 's.medicine_id = m.id'.
// 4. It uses aliases (AS) so your HTML table code doesn't need to change.
$query = "SELECT s.id AS sale_id, s.sale_date, m.name AS medicine_name, s.quantity_sold AS quantity
          FROM sale s
          JOIN medicine m ON s.medicine_id = m.id
          ORDER BY s.id DESC";
// --- END OF FIX ---

$result = mysqli_query($conn, $query);

// Check for query errors (good practice)
if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Sales</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Sales List</h2>

<table>
    <tr>
        <th>Sale ID</th>
        <th>Date</th>
        <th>Medicine</th>
        <th>Quantity</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['sale_id']; ?></td>
        <td><?php echo $row['sale_date']; ?></td>
        <td><?php echo $row['medicine_name']; ?></td>
        <td><?php echo $row['quantity']; ?></td>
    </tr>
    <?php } ?>
</table>

<a href="add_sales.php">Add Sale</a>
</body>
</html>

<?php mysqli_close($conn); ?>