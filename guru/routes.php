<?php
require_once 'controllers/AuthController.php';

$page = $_GET['page'] ?? 'login';

$authController = new AuthController();

switch ($page) {
    case 'login':
        $authController->loginPage();
        break;
    case 'login_process':
        $authController->login();
        break;
    case 'logout':
        $authController->logout();
        break;
    default:
        echo "404 Not Found";
}
