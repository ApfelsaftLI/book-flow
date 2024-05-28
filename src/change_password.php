<?php
session_start();
$isLoggedIn = array_key_exists("user", $_SESSION);

if (!$isLoggedIn) {
    header("Location: index.php");
    exit;
}


?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assets/styles/change_password.css">
    <link rel="shortcut icon" href="assets/images/BookFlow_Icon.svg" type="image/svg">
    <title>Buch | BookFlow</title>
</head>
<body class="grid-container">
<?php include_once "templates/header.php"; ?>
<main class="grid-container">
        <form class="editForm large-container new-user-form" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">

            <label for="oldPassword">Altes Passwort:</label>
            <input type="password" name="oldPassword" id="oldPassword">

            <label for="newPassword">Neues Passwort:</label>
            <input type="password" name="newPassword" id="newPassword">

            <label for="newPasswordRepeat">Neues Passwort:</label>
            <input type="password" name="newPasswordRepeat" id="newPasswordRepeat">

        </form>
</main>
<?php include_once "templates/footer.php"; ?>
</body>
</html>
