<?php
session_start();
$db = include('../config.php');
include('../controllers/RelationController.php');
use controllers\RelationController;
$relationController=new RelationController($db);
include ('../controllers/PostController.php');
use controllers\PostController;
$postController = new PostController($db);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Connexion</title>
</head>
<body>
<?php include(__DIR__ . '/../headers/header_views.php'); ?>
<main>
    <?php
    $user=$relationController->getUser($_SESSION['userId']);
    $nbFriends=$relationController->getNbFriends($_SESSION['userId']);

    ?>
    <div class="user-profile">
        <div class="info-profil">
            <h3><?=$user['pseudo']?></h3>
            <form action="friendsList.php">
                <input type="hidden" name="userId" value="<?=$_SESSION['userId']?>">
                <button id="friend" type="submit" name="friends" value="friends">Amis <?=$nbFriends?></button>
            </form>
        </div>
        <div class="user-post-profile">
            <?php
            include ('showPostUser.php');
            ?>
        </div>
        <div id="pagination">
            <?php
            $totalPosts = $postController->getPostCount();
            $postsPerPage = 10;
            $totalPages = ceil($totalPosts / $postsPerPage);

            $page = isset($_GET['page']) ? $_GET['page'] : 1;

            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<a class="' . ($page == $i ? 'active' : '') . '" href="?page=' . $i . '">' . $i . '</a>';
            }
            ?>
        </div>
    </div>




</main>
<?php include(__DIR__ . '/../footer.php'); ?>
</body>
</html>
