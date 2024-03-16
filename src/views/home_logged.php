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
    <title>Accueil</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="./assets/js/script.js"></script>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include('../headers/header_views.php'); ?>
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
                        if($relationController->isFriend($_SESSION['userId'],$user['id'])==="amis" || $relationController->isFriend($user['id'],$_SESSION['userId'])==="amis"){
                            ?>
                            <form action="../controllers/RelationController.php" method="post">
                                <input type="hidden" name="userId" value="<?=$user['id']?>">
                                <button type="submit" name="deleteFriend" value="deleteFriend">Supprimer de mes amis</button>
                            </form>
                            <?php
                        } if ($relationController->isFriend($user['id'],$_SESSION['userId'])==="attente"){
                            ?>
                            <form>
                                <button>Demande reçue</button>
                            </form>
                            <?php
                        }elseif ($relationController->isFriend($_SESSION['userId'],$user['id'])===NULL && $relationController->isFriend($user['id'],$_SESSION['userId'])===NULL) {
                            ?>
                            <form action="../controllers/RelationController.php" method="post">
                                <input type="hidden" name="userId" value="<?=$user['id']?>">
                                <button type="submit" name="addFriend" value="addFriend">Ajouter un ami</button>
                            </form>
                            <?php
                        } elseif ($relationController->isFriend($_SESSION['userId'],$user['id'])==="attente"){
                            ?>
                            <form action="../controllers/RelationController.php" method="post">
                                <input type="hidden" name="userId" value="<?=$user['id']?>">
                                <button type="submit" name="cancelFriend" value="cancelFriend">Annuler la demande</button>
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

               <label for="type">Type:</label>
                <select name="type" id="type">
                     <option value="public">Public</option>
                     <option value="private">Privé</option>
                </select>

               <button type="submit">Publier une publication</button>
           </form>
           <?php
           include ('showPost.php');
           ?>
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
    </div>
</main>
<?php include(__DIR__ . '/../footer.php'); ?>
</body>
</html>


