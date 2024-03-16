<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Comment</title>
</head>
<body>
<?php include(__DIR__ . '/../headers/header_views.php'); ?>
<main>
    <h2>Commentaire</h2>
    <form id="comment-form" action="../controllers/CommentController.php" method="post">
        <input type="hidden" name="postId" value="<?= $_GET['postId'] ?>">
        <label for="content">Commentaire :</label>
        <textarea id="content" name="content" required></textarea>
        <button type="submit">Envoyer</button>
    </form>
</main>
<?php include(__DIR__ . '/../footer.php'); ?>
</body>
</html>
