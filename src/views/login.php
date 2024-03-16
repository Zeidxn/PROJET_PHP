<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Connexion</title>
</head>
<body>
<?php include(__DIR__ . '/../headers/header.php'); ?>
<main>
    <h2>Connexion</h2>
    <form id="login-register" action="index.php?page=login" method="post">
        <label for="email">Adresse email :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Se connecter</button>
    </form>
</main>
<?php include(__DIR__ . '/../footer.php'); ?>
</body>
</html>
