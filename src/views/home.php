<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="./assets/css/style.css">

</head>
<body>
<?php include(__DIR__ . '/../headers/header.php');
?>
    <main>
        <div class="home" style="margin-bottom: 30px">
            <h2>Accueil</h2>
            <p>Bienvenue sur mon site !</p>
        </div>



        <!-- Affichage des posts -->
           <div>
           <?php
                $db = include('config.php');
                include ('controllers/PostController.php');

                use controllers\PostController;

                $postController = new PostController($db);
                $posts = $postController->getPosts();
           ?>
               <?php foreach ($posts as $post):
                   if($post['isPublic'] == 0) {
                       continue;
                   }
                   ?>

                   <div class="post-container">
                       <?php $user = $postController->getUserName($post['owner']); ?>
                       <h3><?= $user ?></h3>
                       <h2><?= $post['title'] ?></h2>
                       <p><?= $post['content'] ?></p>
                       <?php
                       if ($post['imageData'] != null && trim($post['imageData']) != "") {
                           $imageData = base64_encode($post['imageData']);
                           $imageType = pathinfo($post['imageData'], PATHINFO_EXTENSION);
                           $imageSrc = 'data:image/' . $imageType . ';base64,' . $imageData;

                           echo '<img src="' . $imageSrc . '" alt="Post Image">';
                       }
                       ?>
                   </div>
               <?php endforeach; ?>
    </main>
    <?php include(__DIR__ . '/../footer.php'); ?>

</body>
</html>