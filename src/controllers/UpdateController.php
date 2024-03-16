<?php
session_start();

use controllers\PostController;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['postId'])) {
    $userId = $_SESSION['userId'];
    $postId = $_POST['postId'];
    $content = $_POST['content'];
    $title = $_POST['title'];
    $currentImage = $_POST['currentImage'];

    if (!empty($_FILES["fileUpload"]["name"])) {
        $tempFilePath = $_FILES["fileUpload"]["tmp_name"];

        if (getimagesize($tempFilePath)) {
            $imagedata = file_get_contents($tempFilePath);
        } else {
            echo "Le fichier n'est pas une image valide.";
            exit();
        }
    } else {
        $imagedata = null;
    }

    $db = include('../config.php');
    include('PostController.php');
    $postController = new PostController($db);

    $postController->updatePost($postId, $title, $content, $imagedata);
    header("Location: ../views/home_logged.php");
    exit();
}
?>
