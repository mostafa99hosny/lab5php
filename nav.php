<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Navbar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <a href="addcustomer.php">Add Customer</a>
        <a href="#">Products</a>
        <a href="listcustomer.php">Users</a>
        <a href="#">Checks</a>
        <h2>
            <img src="user.png" alt="user" width="50px">
            Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
        </h2>
    </div>
</body>
</html>