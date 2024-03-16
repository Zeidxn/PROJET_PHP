<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>PROJET Toupin Nicolas</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include('../headers/header_admin.php'); ?>
<main>
    <h2>Accueil</h2>
    <p>Bienvenue sur mon site !</p>

    <?php

    $db = include('../config.php');
    include ('../controllers/AdminController.php');

    use controllers\AdminController;

    $adminController = new AdminController($db);
    $users = $adminController->getMembers();


    foreach ($users as $user): ?>
    <div class="user-container">
        <h3><?= $user['pseudo'] ?></h3>
        <p><?= $user['email'] ?></p>
        <p><?= $user['role'] ?></p>
        <form action="../controllers/AdminController.php" method="post">
            <input type="hidden" name="userId" value="<?= $user['id'] ?>">
            <button type="submit" name="delete">Supprimer</button>
        </form>
    </div>
    <?php endforeach;
    ?>
    <form id="mail-form" action="../controllers/AdminController.php" method="post">
        <label for="selectedUser">Sélectionnez un utilisateur :</label>
        <select name="selectedUser" id="selectedUser">
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id'] ?>">
                    <?= $user['pseudo'] ?> - <?= $user['email'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="emailSubject">Sujet de l'e-mail :</label>
        <input type="text" name="emailSubject" required>
        <label for="emailMessage">Contenu de l'e-mail :</label>
        <textarea name="emailMessage" required></textarea>
        <button type="submit" name="sendEmailToSelected">Envoyer un e-mail</button>
    </form>

</main>
<?php include(__DIR__ . '/../footer.php'); ?>
</body>
</html>
