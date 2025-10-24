<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connect.php';

// This is your query to get all medicines
$query = "SELECT * FROM medicine ORDER BY id";
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
    <title>View Medicines</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <header>
            <h1>Medicine List</h1>
        </header>

        <main class="content-wrapper">
            
            <table class="content-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>
                            <a href="update_medicine.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <a href="delete_medicine.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <nav class="page-nav">
                <a href="add_medicine.php">Add New Medicine</a>
                <a href="index.php">Back to Home</a>
            </nav>
        </main>
    </div>

</body>
</html>
<?php mysqli_close($conn); ?>