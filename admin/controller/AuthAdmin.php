<?php
session_name("admin_session");
session_start();
require_once __DIR__ . "/../model/AdminModel.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $admin = AdminModel::getAdminByEmail($email);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_login'] = true;
        $_SESSION['admin_email'] = $email;
        header("Location: ../view/dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Email atau password salah!";
        header("Location: ../view/login.php");
        exit();
    }
}
?>
