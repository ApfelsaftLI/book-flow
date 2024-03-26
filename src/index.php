<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $_SESSION = [];
    $_SESSION["user"] = ["admin" => "true", "name" => "Landolt", "firstName" => "Tim"];
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/styles/main.css">
    <link rel="shortcut icon" href="assets/images/BookFlow_Icon.svg" type="image/svg">
    <title>Home | BookFlow</title>

    <style> a[href="/"] {
            font-weight: bold
        }</style>

</head>
<body class="grid-container">
<?php include_once "templates/header.php" ?>
<main>
    <h3>
        <?php print_r($_SESSION) ?>
    </h3>
</main>

<footer>

</footer>
</body>
</html>
