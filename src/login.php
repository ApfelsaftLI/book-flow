<?php
session_start();

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
<header>
    <a href="/">
        <img src="../assets/images/BookFlow_Logo.svg" alt="BookFlow Logo">
    </a>
</header>
<main class="grid-container">
    <div class="login-container large-container">
        <h1 class="text-large-bold">Login</h1>
        <form action="/" method="post">
            <input type="email" name="email" id="login-email" placeholder="Email" maxlength="50" required>
            <input type="password" name="password" id="login-password" placeholder="Passwort" maxlength="50" required>
            <div id="login-button-wrapper">
                <a href="/" class="outline-button">Abbrechen</a>
                <button type="submit" class="big-button">Anmelden</button>
            </div>
        </form>
    </div>
</main>
<footer>
    <p class="text-small-semi">&copy; BookFlow <?php echo date("Y") ?></p>
</footer>
</body>
</html>