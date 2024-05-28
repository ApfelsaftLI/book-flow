<?php
session_start();

$isLoggedIn = array_key_exists("user", $_SESSION);
$isAdmin = $isLoggedIn && $_SESSION["user"]["admin"] == "true";

if (!$isAdmin || !isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}


include_once "includes/functions.php";
include_once "includes/db.php";

$id = $_GET['id'];
$user = getCustomer($id);
$fullName = $user['vorname'] . " " . $user['name'];
if ($user['geschlecht'] != "M" && $user['geschlecht'] != "F") $user['geschlecht'] = "N";
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assets/styles/new_user.css">
    <link rel="shortcut icon" href="assets/images/BookFlow_Icon.svg" type="image/svg">
    <title>Kunde bearbeiten | BookFlow</title>
</head>
<body class="grid-container">
<?php include_once "templates/header.php"; ?>
<main class="grid-container">
    <form class="new-user-form" action="./users.php?filter=customers" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <h1 class="text-large-bold"><?= $fullName ?> bearbeiten</h1>
        <div class="name">
            <label for="name" class="text-medium-normal">Voller Name*:</label>
            <input type="text" name="name" id="name" required="true" value="<?= $fullName ?>">
        </div>
        <div class="email">
            <label for="email" class="text-medium-normal">E-Mail Addresse*:</label>
            <input type="email" name="email" id="email" required="true" value="<?= $user['email'] ?>">
        </div>
        <div>
            <input type="checkbox" name="mailcontact" id="mailcontact" class="text-small-normal"
                   value="1" <?= $user['kontaktpermail'] == 1 ? "checked" : "" ?>>
            <label for="mailcontact" class="text-small-semi">Mailkontakt</label>
        </div>
        <div>
            <label for="birthdate" class="text-medium-normal">Geburtsdatum:</label>
            <input type="date" name="birthdate" id="birthdate"
                   value="<?= validateDate($user['geburtstag']) ? $user['geburtstag'] : "" ?>">
        </div>
        <div class="gender">
            <input type="radio" name="gender" id="gender-male" value="M" checked>
            <label for="gender-male" class="text-small-semi">Männlich</label>
            <input type="radio" name="gender" id="gender-female"
                   value="F" <?= $user['geschlecht'] == "F" ? "checked" : "" ?>>
            <label for="gender-female" class="text-small-semi">Weiblich</label>
            <input type="radio" name="gender" id="gender-none"
                   value="N" <?= $user['geschlecht'] == "N" ? "checked" : "" ?>>
            <label for="gender-none" class="text-small-semi">Keine Angabe</label>
        </div>
        <p class="text-small-normal">* erforderlich</p>
        <div class="button-container">
            <a href="./users.php?filter=customers" class="outline-button">Abbrechen</a>
            <button type="submit" class="big-button">Kunde bearbeiten</button>
        </div>
    </form>
    <form action="users.php?filter=customers" method="post" class="delete-form">
        <input type="hidden" name="d-id" value="<?= $id ?>">
        <input type="hidden" name="delete" value="true">
        <button type="submit" class="outline-button">Kunde löschen</button>
    </form>
</main>
<?php include_once "templates/footer.php"; ?>
</body>
</html>
