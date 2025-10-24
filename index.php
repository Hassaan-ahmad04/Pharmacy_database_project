<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pharmacy Management System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        h1 { text-align: center; }
        .menu { display: flex; flex-direction: column; align-items: center; gap: 10px; margin-top: 30px; }
        .menu a {
            display: block;
            width: 200px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }
        .menu a:hover { background-color: #45a049; }
    </style>
</head>
<body>

<h1>Pharmacy Management System</h1>

<div class="menu">
    <h2>Medicine Module</h2>
    <a href="add_medicine.php">Add New Medicine</a>
    <a href="view_medicine.php">View Medicines (Edit/Delete)</a>

    <h2>Sales Module</h2>
    <a href="add_sales.php">Add Sale</a>
    <a href="view_sales.php">View Sales</a>
</div>

</body>
</html>
