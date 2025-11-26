<?php
session_start();

include_once "includes/functions.php";
include_once "includes/db.php";
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assets/styles/register.css">
    <link rel="shortcut icon" href="assets/images/BookFlow_Icon.svg" type="image/svg">
    <title>Registrieren | BookFlow</title>
</head>
<body class="grid-container">
<?php include_once "templates/header.php"; ?>
<main class="grid-container">
    <form class="register-form" action="/" method="post">
        <h1 class="text-large-bold">Registrieren</h1>
        <div class="name">
            <label for="name" class="text-medium-normal">Voller Name*:</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div class="email">
            <label for="email" class="text-medium-normal">E-Mail*:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="username">
            <label for="username" class="text-medium-normal">Benutzername*:</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div class="password">
            <label for="bassword" class="text-medium-normal">Passwort*:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div class="password-1">
            <label for="bassword-2" class="text-medium-normal">Wiederholen*:</label>
            <input type="password" name="password-2" id="password-2" required>
        </div>
        <p class="text-small-normal">* erforderlich</p>
        <input type="hidden" name="register" value="true">
        <div class="button-container">
            <a href="/" class="outline-button">Abbrechen</a>
            <button type="submit" class="big-button">Registrieren</button>
        </div>
    </form>
</main>
<?php include_once "templates/footer.php"; ?>
</body>
</html>
