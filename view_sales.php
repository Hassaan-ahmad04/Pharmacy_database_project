<?php
include 'db_connect.php';

$sales = pg_query($conn, "
    SELECT s.sale_id, s.sale_date, m.medicine_name, sd.quantity 
    FROM sales s 
    JOIN sale_details sd ON s.sale_id = sd.sale_id 
    JOIN medicine m ON sd.medicine_id = m.medicine_id
    ORDER BY s.sale_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales List</title>
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

<?php while ($row = pg_fetch_assoc($sales)) { ?>
<tr>
    <td><?php echo $row['sale_id']; ?></td>
    <td><?php echo $row['sale_date']; ?></td>
    <td><?php echo $row['medicine_name']; ?></td>
    <td><?php echo $row['quantity']; ?></td>
</tr>
<?php } ?>

</table>

<br>
<a href="add_sale.php">Add New Sale</a> | <a href="add_medicine.php">Add Medicine</a>
</body>
</html>

<?php pg_close($conn); ?>
