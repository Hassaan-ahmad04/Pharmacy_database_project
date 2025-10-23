<?php
include 'db_connect.php';

// Fetch all medicines
$query = "SELECT * FROM medicine WHERE is_active = TRUE ORDER BY medicine_id ASC";
$result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Medicines</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>All Medicines</h2>
    <a href="add_medicine.php">Add New Medicine</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Actions</th>
        </tr>
        <?php while($row = pg_fetch_assoc($result)) { ?>
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
