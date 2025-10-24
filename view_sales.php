<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

$query = "SELECT s.sale_id, s.sale_date, m.medicine_name, sd.quantity
          FROM sale s
          JOIN sale_details sd ON s.sale_id = sd.sale_id
          JOIN medicine m ON sd.medicine_id = m.medicine_id
          ORDER BY s.sale_id DESC";

$result = mysqli_query($conn, $query);

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
