<?php
// This line enables error reporting, which you added. It's good to keep!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Management System</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">

        <header>
            <h1>Pharmacy Management System</h1>
        </header>

        <main>
            <section class="module">
                <h2>Medicine Module</h2>
                <a href="add_medicine.php" class="btn">Add New Medicine</a>
                <a href="view_medicine.php" class="btn btn-secondary">View Medicines (Edit/Delete)</a>
            </section>

            <section class="module">
                <h2>Sales Module</h2>
                <a href="add_sales.php" class="btn">Add Sale</a>
                <a href="view_sales.php" class="btn btn-secondary">View Sales</a>
            </section>
        </main>
        
    </div>

</body>
</html>