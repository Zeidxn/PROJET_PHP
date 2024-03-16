<?php
include ('../controllers/RelationController.php');
use controllers\RelationController;
$db = include('../config.php');
$relationController = new RelationController($db);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Amis</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include(__DIR__ . '/../headers/header_views.php'); ?>
<main>
    <div class="friends-list">
        <?php
        session_start();
        $friends=$relationController->getFriends($_SESSION['userId']);
        foreach ($friends as $friend) {
            ?>
            <div class="friend">
                <h3><?=$friend['pseudo']?></h3>
                <form action="profileFriends.php" method="post">
                    <input type="hidden" name="userId" value="<?=$friend['id']?>">
                    <button type="submit" name="profile" value="profile">Voir le profil</button>
                </form>
            </div>
            <?php
        }
        ?>
    </div>
