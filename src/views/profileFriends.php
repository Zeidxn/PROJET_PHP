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
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Connexion</title>
</head>
<body>
<?php include(__DIR__ . '/../headers/header_views.php'); ?>
<main>
    <?php
    if (isset($_POST['userId'])) {
        $user=$relationController->getUser($_POST['userId']);


    $nbFriends=$relationController->getNbFriends($_SESSION['userId']);

    ?>
    <div class="user-profile">
        <div class="info-profil">
            <h3><?=$user['pseudo']?></h3>
            <button type="submit" name="friends" value="friends">Amis <?=$nbFriends?></button>
        </div>
        <div class="user-post-profile">
            <?php
            include ('showPostFriends.php');
            ?>
        </div>
    </div>
    <?php
    }?>




</main>
<?php include(__DIR__ . '/../footer.php'); ?>
</body>
</html>
