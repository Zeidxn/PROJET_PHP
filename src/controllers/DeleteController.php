<?php

use controllers\PostController;

if ($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($_POST['postId'])) {
    session_start();
    $postId = $_POST['postId'];

    $db = include('../config.php');
    include('PostController.php');
    $postController = new PostController($db);

    $postController->deletePost($postId);

    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit();
}
?>
