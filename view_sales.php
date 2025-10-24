<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

// This is your corrected query
$query = "SELECT s.id AS sale_id, s.sale_date, m.name AS medicine_name, s.quantity_sold AS quantity
          FROM sale s
          JOIN medicine m ON s.medicine_id = m.id
          ORDER BY s.id DESC";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Sales</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <header>
            <h1>Sales List</h1>
        </header>
        
        <main class="content-wrapper">

            <table class="content-table">
                <thead>
                    <tr>
                        <th>Sale ID</th>
                        <th>Date</th>
                        <th>Medicine</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['sale_id']; ?></td>
                        <td><?php echo $row['sale_date']; ?></td>
                        <td><?php echo htmlspecialchars($row['medicine_name']); ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <nav class="page-nav">
                <a href="add_sales.php">Add Sale</a>
                <a href="index.php">Back to Home</a>
            </nav>
        </main>
    </div>

</body>
</html>
<?php mysqli_close($conn); ?>