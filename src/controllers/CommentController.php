<?php

use controllers\PostController;

if ($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($_POST['postId'])) {
    session_start();
    $postId = $_POST['postId'];


    $db = include('../config.php');
    include('PostController.php');
    $postController = new PostController($db);

    $postController->commentPost($postId, $_SESSION['userId'], $_POST['content']);

    header("Location: " . "../views/home_logged.php");
    exit();
}
?>