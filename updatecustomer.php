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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $roomId = $_POST['room_id'];
    $profilePicture = null;

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $file_name = uniqid() . "_" . basename($_FILES['profile_picture']['name']);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            $profilePicture = $target_file;
        } else {
            die("Sorry, there was an error uploading your file.");
        }
    }

    $result = $customer->updateCustomer($id, $name, $email, $roomId, $profilePicture);

    if ($result) {
        header("Location: listcustomer.php");
        exit();
    } else {
        die("Failed to update customer.");
    }
}
?>