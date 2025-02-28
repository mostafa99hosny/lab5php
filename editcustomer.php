<?php
require_once 'Config.php';
require_once 'Auth.php';
require_once 'Customer.php';

$auth = new Auth();
$config = new Config();
$customer = new Customer($config->getPdo());

if (!$auth->isLoggedIn()) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Invalid customer ID.");
}

$customerData = $customer->getCustomerById($id);
if (!$customerData) {
    die("Customer not found.");
}

$rooms = $customer->getAllRooms();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include_once 'nav.php'; ?>
    <div class="content">
        <h2>Edit Customer</h2>
        <form action="updatecustomer.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $customerData['id']; ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($customerData['name']); ?>" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($customerData['email']); ?>" required><br><br>

            <label for="profile_picture">Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*"><br><br>

            <label for="room_id">Room:</label>
            <select id="room_id" name="room_id">
                <?php foreach ($rooms as $room): ?>
                    <option value="<?php echo $room['id']; ?>" <?php echo $room['id'] == $customerData['room_id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($room['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <input type="submit" value="Update">
            <input type="button" value="Cancel" onclick="window.location.href='listcustomer.php'">
        </form>
    </div>
    <?php include_once 'footer.php'; ?>
</body>
</html>