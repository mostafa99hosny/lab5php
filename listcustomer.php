<?php
require_once 'Config.php';
require_once 'Auth.php';
require_once 'Customer.php';

$auth = new Auth();
$config = new Config();
$customer = new Customer($config->getPdo());

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!$auth->isLoggedIn()) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $customer->deleteCustomer($deleteId);
    header("Location: listcustomer.php");
    exit();
}

$customers = $customer->getAllCustomers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include_once 'nav.php'; ?>
    <div style="padding: 20px;">
        <h2 style="margin: 15px;">Registered Users</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Room</th>
                    <th>Profile Picture</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customerData): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($customerData['name']); ?></td>
                        <td><?php echo htmlspecialchars($customerData['email']); ?></td>
                        <td><?php echo htmlspecialchars($customerData['room_name'] ?? 'No Room'); ?></td>
                        <td>
                            <img src="<?php echo htmlspecialchars($customerData['profile_picture']); ?>" alt="Profile Picture">
                        </td>
                        <td class="action-buttons">
                            <a href="editcustomer.php?id=<?php echo $customerData['id']; ?>">
                                <button>Update</button>
                            </a>
                            <button onclick="deleteCustomer(<?php echo $customerData['id']; ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include_once 'footer.php'; ?>

    <script>
        function deleteCustomer(id) {
            if (confirm("Are you sure you want to delete this customer?")) {
                window.location.href = `listcustomer.php?delete_id=${id}`;
            }
        }
    </script>
</body>
</html>