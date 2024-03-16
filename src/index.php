<?php


use controllers\AuthenController;

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

$db=include ('config.php');
include ('controllers/AuthenController.php');

$authenController = new AuthenController($db);

$isAuthenticated = $authenController->isLoggedIn();



switch ($page) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authenController->login();
        }
        else {
            include 'views/login.php';
        }
        break;
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authenController->register();
        } else {
            include 'views/register.php';
        }
        break;
    case 'home':
        if ($isAuthenticated) {
            include 'views/home_logged.php';
        } else {
            include 'views/home.php';
        }
        break;
    case 'logout':
        $authenController->logout();
        break;
    default:
        include 'views/home.php';
}
?>

