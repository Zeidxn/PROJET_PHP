<?php
use controllers\PostController;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    session_start();
    $postId = $_POST['postId'];

    $db = include('../config.php');
    include('../controllers/PostController.php');
    $postController = new PostController($db);

    $postInfo = $postController->getPostInfo($postId);

    include('../headers/header_views.php');

    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Modifier la publication</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
    <div class="edit-post-container">
        <h2>Modifier la publication</h2>
        <form class="edit-post-form" action="../controllers/UpdateController.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="postId" value="<?= $postInfo['id'] ?>">
            <input type="hidden" name="currentImage" value="<?= htmlspecialchars($postInfo['imageData']) ?>">


            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" value="<?= $postInfo['title'] ?>" required>

            <label for="content">Contenu :</label>
            <textarea id="content" name="content"><?= $postInfo['content'] ?></textarea>

            <label for="fileUpload">Sélectionner une photo :</label>
            <input type="file" name="fileUpload" id="fileUpload">


            <button type="submit">Enregistrer les modifications</button>
        </form>

    </div>
    </body>
    </html>
    <?php
} else {
    // Redirigez ou affichez un message d'erreur si nécessaire
    header("Location: index.php");
    exit();
}
?>
