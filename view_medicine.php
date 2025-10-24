<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

$result = mysqli_query($conn, "SELECT * FROM medicine ORDER BY medicine_id");

?>

<!DOCTYPE html>
<html>
<head>
    <title>View Medicines</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Medicine List</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Actions</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['medicine_id']; ?></td>
        <td><?php echo $row['medicine_name']; ?></td>
        <td><?php echo $row['price']; ?></td>
        <td><?php echo $row['quantity']; ?></td>
        <td>
            <a href="update_medicine.php?id=<?php echo $row['medicine_id']; ?>">Edit</a> |
            <a href="delete_medicine.php?id=<?php echo $row['medicine_id']; ?>" 
               onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>

<a href="add_medicine.php">Add New Medicine</a>
</body>
</html>

<?php mysqli_close($conn); ?>
