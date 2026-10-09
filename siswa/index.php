<?php
require_once "App/Controllers/AuthController.php";
require_once "public/login.php";

use App\Controllers\AuthController;

$auth = new AuthController($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $auth->login($_POST["email"], $_POST["password"]);
} elseif (isset($_GET["logout"])) {
    $auth->logout();
}
?>
