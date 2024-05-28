<?php
session_start();

$isLoggedIn = array_key_exists("user", $_SESSION);
$isAdmin = $isLoggedIn && $_SESSION["user"]["admin"] == "true";

if (!$isAdmin) {
    header("Location: index.php");
    exit;
}

include_once "includes/functions.php";
include_once "includes/db.php";
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assets/styles/new_user.css">
    <link rel="shortcut icon" href="assets/images/BookFlow_Icon.svg" type="image/svg">
    <title>Neuer Kunde | BookFlow</title>
</head>
<body class="grid-container">
<?php include_once "templates/header.php"; ?>
<main class="grid-container">
    <form class="new-user-form" action="./users.php?filter=customers" method="post">
        <h1 class="text-large-bold">Kunde erfassen</h1>
        <div>
            <label for="name" class="text-medium-normal">Voller Name*:</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div class="email">
            <label for="email" class="text-medium-normal">E-Mail Addresse*:</label>
            <input type="email" name="email" id="email" required>
            <input type="checkbox" name="mailcontact" id="mailcontact" class="text-small-normal" value="1">
            <label for="mailcontact" class="text-small-semi">Mailkontakt</label>
        </div>
        <div>
            <label for="birthdate" class="text-medium-normal">Geburtsdatum:</label>
            <input type="date" name="birthdate" id="birthdate">
        </div>
        <div class="gender">
            <input type="radio" name="gender" id="gender-male" value="M" checked>
            <label for="gender-male" class="text-small-semi">Männlich</label>
            <input type="radio" name="gender" id="gender-female" value="F">
            <label for="gender-female" class="text-small-semi">Weiblich</label>
        </div>
        <p class="text-small-normal">* erforderlich</p>
        <div class="button-container">
            <a href="./users.php?filter=customers" class="outline-button">Abbrechen</a>
            <button type="submit" class="big-button">Kunde erfassen</button>
        </div>
    </form>
</main>
<?php include_once "templates/footer.php"; ?>
</body>
</html>
