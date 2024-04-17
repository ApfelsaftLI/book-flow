<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $_SESSION = [];
    $_SESSION["user"] = ["admin" => "true", "name" => "Bernardini", "vorname" => "Vincent"];
}
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assets/styles/login.css">
    <link rel="shortcut icon" href="assets/images/BookFlow_Icon.svg" type="image/svg">
    <title>Login | BookFlow</title>
</head>
<body class="grid-container">
<main class="grid-container">
    <div class="login-container large-container">
        <form action="/" method="post">
            <input type="email" name="email" id="login-email" placeholder="Email" required>
            <input type="password" name="password" id="login-password" placeholder="Passwort" required>
            <button type="submit" class="big-button">Anmelden</button>
        </form>
    </div>
</main>
<footer>
    <p class="text-small-semi">&copy; BookFlow <?php echo date("Y") ?></p>
</footer>
</body>
</html>