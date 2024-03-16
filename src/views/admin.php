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
    <title>PROJET Toupin Nicolas</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="./assets/js/script.js"></script>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include('../headers/header_admin.php'); ?>
<main>
    <div class="home">
        <h2>Accueil</h2>
        <p>Bienvenue sur mon site !</p>
    </div>


    <div class="user-post-container">
        <div class="user-add">
            <?php
            $users=$relationController->showUsers();
            $requests=$relationController->getRequests($_SESSION['userId']);
            foreach ($users as $user){
                if($user['id']!=$_SESSION['userId']){
                    ?>
                    <div id="user-friends">
                        <h3><?=$user['pseudo']?></h3>
                        <?php
                        $relationStatut=$relationController->isFriend($_SESSION['userId'],$user['id']);
                        foreach ($requests as $request){
                            if($request['idEnvoyant']===$user['id']){
                                $relationStatut="attente";
                            }
                        }

                        if($relationStatut==="amis"){
                            ?>
                            <form action="../controllers/RelationController.php" method="post">
                                <input type="hidden" name="userId" value="<?=$user['id']?>">
                                <button type="submit" name="deleteFriend" value="deleteFriend">Supprimer de mes amis</button>
                            </form>
                            <?php
                        }elseif($relationStatut==="attente"){
                            ?>
                            <form>
                                <input type="hidden" name="userId" value="<?=$user['id']?>">
                                <button>Attente</button>
                            </form>
                            <?php

                        }else{
                            ?>
                            <form action="../controllers/RelationController.php" method="post">
                                <input type="hidden" name="userId" value="<?=$user['id']?>">
                                <button type="submit" name="addFriend" value="addFriend">Ajouter en ami</button>
                            </form>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>


        <!-- Affichage des posts -->
        <div class="form-post">
            <form id="login-register" action="../controllers/Upload.php" method="post" enctype="multipart/form-data">
                <label for="title">Titre :</label>
                <input type="text" id="title" name="title" required>

                <label for="content">Contenu :</label>
                <textarea id="content" name="content"></textarea>

                <label for="fileUpload">Sélectionner une photo :</label>
                <input type="file" name="fileUpload" id="fileUpload">

                <button type="submit">Publier une publication</button>
            </form>
            <?php
            include ('showPostadmin.php');
            ?>

        </div>
    </div>
</main>
<?php include(__DIR__ . '/../footer.php'); ?>
</body>
</html>


