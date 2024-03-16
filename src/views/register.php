<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Inscription</title>
</head>
<body>
<?php include(__DIR__ . '/../headers/header.php'); ?>
<main>
    <h2>Inscription</h2>
    <form id="login-register" action="./index.php?page=register" method="post">
        <label for="email">Adresse email :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <label for="pseudo">Pseudo :</label>
        <input type="text" id="pseudo" name="pseudo" required>

        <label for="firstname">Prénom :</label>
        <input type="text" id="firstname" name="firstname" required>

        <label for="lastname">Nom :</label>
        <input type="text" id="lastname" name="lastname" required>

        <label for="age">Age :</label>
        <input type="number" id="age" name="age" required>

        <label for="address">Adresse :</label>
        <input type="text" id="address" name="address" required>

        <label for="phoneNumber">Numéro de téléphone: </label>
        <input type="tel" id="phoneNumber" name="phoneNumber" required>

        <button type="submit">S'inscrire</button>
    </form>
</main>
<?php include(__DIR__ . '/../footer.php'); ?>
</body>
</html>
