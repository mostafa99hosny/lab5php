<?php
class Auth {
    private $username = "mostafa";
    private $password = "123";

    public function login($form_username, $form_password) {
        if ($form_username === $this->username && $form_password === $this->password) {
            session_start();
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $this->username;
            header("Location: addcustomer.php");
            exit();
        } else {
            return "Invalid username or password";
        }
    }

    public function isLoggedIn() {
        session_start();
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
}