<?php
session_start();

use controllers\PostController;

include ('./PostController.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si un fichier a été téléchargé
    if (!empty($_FILES["fileUpload"]["name"])) {
        $tempFilePath = $_FILES["fileUpload"]["tmp_name"];

        // Vérifier si le fichier est une image
        if (getimagesize($tempFilePath)) {
            $imageData = file_get_contents($tempFilePath);
        } else {
            echo "Le fichier n'est pas une image valide.";
            exit();
        }
    } else {
        $imageData = null;
    }

    $type = $_POST["type"] === "public" ? 1 : 0;

    $db = include("../config.php");

    $postController = new PostController($db);
    $postController->createPost($_POST["title"], $_POST["content"], $type, 0, 0, $imageData, $_SESSION['userId']);

    header("Location: ../views/home_logged.php");
    exit();
} else {
    echo "Méthode non autorisée.";
}
?>
