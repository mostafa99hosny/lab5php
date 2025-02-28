<?php
require_once 'Config.php';
require_once 'Auth.php';
require_once 'Customer.php';
require_once 'Validation.php';

$auth = new Auth();
$config = new Config();
$customer = new Customer($config->getPdo());
$validation = new Validation();

if (!$auth->isLoggedIn()) {
    header("Location: index.php");
    exit();
}

$rooms = $customer->getAllRooms();
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $room_no = $_POST['room_no'];

    if (!$validation->validateEmail($email)) {
        $message = "<div class='error'>Invalid email format</div>";
    } elseif (strlen($password) < 8) {
        $message = "<div class='error'>Password must be at least 8 characters long.</div>";
    } elseif ($password !== $confirm_password) {
        $message = "<div class='error'>Passwords do not match</div>";
    } elseif (!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error']) {
        $message = "<div class='error'>Please upload a valid profile picture.</div>";
    } else {
        $target_dir = "uploads/";
        $file_name = uniqid() . "_" . basename($_FILES['profile_picture']['name']);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            $customer->insertCustomer($name, $email, $password, $target_file, $room_no);
            $message = "<div class='success'><h3>Customer added successfully</h3></div>";
        } else {
            $message = "<div class='error'>Sorry, there was an error uploading your file.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include_once 'nav.php'; ?>
    <div class="content">
        <h2>Add Customer</h2>
        <?php if (!empty($message)) echo $message; ?>
        <form action="addcustomer.php" method="post" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" name="name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" required>

            <label for="room_no">Room No.:</label>
            <select name="room_no" required>
                <?php foreach ($rooms as $room): ?>
                    <option value="<?php echo $room['id']; ?>"><?php echo $room['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="profile_picture">Profile Picture:</label>
            <input type="file" name="profile_picture" accept="image/*" required>

            <input type="submit" name="register" value="Register">
            <input type="reset" value="Reset">
        </form>
        <div class="show-customer-btn">
            <a href="listcustomer.php">Show Customer</a>
        </div>
    </div>
    <?php include_once 'footer.php'; ?>
</body>
</html>