<?php
require_once 'Config.php';
require_once 'Auth.php';

$auth = new Auth();
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_username = $_POST['username'];
    $form_password = $_POST['password'];
    $error = $auth->login($form_username, $form_password);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2 style="text-align: center;margin: 15px;">Cafeteria</h2>
    <form action="index.php" method="post" style="text-align: center;margin: 15px;">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
    <?php if (!empty($error)) echo $error; ?>
</body>
</html>