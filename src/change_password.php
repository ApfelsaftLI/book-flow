<?php
session_start();
$isLoggedIn = array_key_exists("user", $_SESSION);
$benutzername = htmlspecialchars($_SESSION["user"]["benutzername"]);
//include the db file so we can call those functions
include_once "includes/db.php";

if (!$isLoggedIn) {
    header("Location: index.php");
    exit;
}

//get old and new passwords and check if they are the same. Then check if the old password matches and inserts the new one if it does
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldPassword = trim($_POST["oldPassword"]);
    $newPassword = trim($_POST["newPassword"]);
    $newPasswordRepeat = trim($_POST["newPasswordRepeat"]);

    if ($newPassword !== $newPasswordRepeat) {
        fail("Die Passwörter sind nicht gleich!");
    } else {
        if (checkPassword($benutzername, $oldPassword, $newPassword)) {
            header("Location: index.php");
        }
    }
}

function checkPassword($benutzername, $oldPassword, $newPassword): bool {
    $passwordHash = getPasswordHashUsername($benutzername);
    if (!password_verify($oldPassword, $passwordHash)) {
        return false;
    }

    if (strlen($newPassword) > 50) {
        fail("Das neue Passwort ist zu lang.");
        return false;
    }
    if (empty($newPassword)) {
        fail("Das neue Passwort ist leer!");
        return false;
    }

    $passwordHashed = password_hash($newPassword, PASSWORD_DEFAULT);
    $success = updatePassword($benutzername, $passwordHashed);

    if ($success) {
        return true;
    } else {
        fail("Es ist ein Fehler beim Ändern des Passworts vorgefallen.");
        return false;
    }
}

function fail(string $message) {
    $_SESSION['error_message'] = $message;
    header("Location: change_password.php");
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
    <?php
    //errorhandling
    if (isset($_SESSION['error_message'])) {
        echo "<div class='error'><p><b>Fehler:</b> " . htmlspecialchars($_SESSION['error_message']) . "</p></div>";
        unset($_SESSION['error_message']);
    }
    ?>
    <form class="editForm large-container new-user-form" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <h1 class="text-large-bold">Passwort ändern</h1>

        <label for="oldPassword" class="text-medium-normal">Altes Passwort:</label>
        <input type="password" name="oldPassword" id="oldPassword" required>

        <label for="newPassword" class="text-medium-normal">Neues Passwort:</label>
        <input type="password" name="newPassword" id="newPassword" required>

        <label for="newPasswordRepeat" class="text-medium-normal">Neues Passwort wiederholen:</label>
        <input type="password" name="newPasswordRepeat" id="newPasswordRepeat" required>

        <div class="button-container">
            <button type="button" onclick="history.go(-1);" class="outline-button">Abbrechen</button>
            <button type="submit" class="big-button">Passwort ändern</button>
        </div>
    </form>
</main>
<?php include_once "templates/footer.php"; ?>
</body>
</html>
