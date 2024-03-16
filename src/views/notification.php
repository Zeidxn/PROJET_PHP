<?php
session_start();

$db = include('../config.php');
include ('../controllers/RelationController.php');
use controllers\RelationController;
$relationController=new RelationController($db);
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
<?php include('../headers/header_views.php'); ?>

<?php
$userRequests = $relationController->getFollowers($_SESSION['userId']);
if (empty($userRequests)) {
?>
<div id="user-notif">
    <button>Vous n'avez pas de notification</button>
</div>
<?php
} else {
        foreach ($userRequests as $request):
        if ($request['statut'] === "attente"):
        ?>
        <div id="user-notif">
            <h3><?= $request['pseudo'] ?></h3>
            <form action="../controllers/RelationController.php" method="post">
                <input type="hidden" name="userId" value="<?= $request['idEnvoyant'] ?>">
                <button type="submit" name="acceptFriend" value="acceptFriend">Accepter la demande</button>
            </form>
            <form action="../controllers/RelationController.php" method="post">
                <input type="hidden" name="userId" value="<?= $request['idEnvoyant'] ?>">
                <button type="submit" name="refuseFriend" value="refuseFriend">Refuser la demande</button>
            </form>
        </div>
        <?php
        endif;
        endforeach;
    }
?>


</body>
</html>
