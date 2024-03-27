<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $_SESSION = [];
    $_SESSION["user"] = ["admin" => "true", "name" => "Bernardini", "firstName" => "Vincent"];
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assets/styles/home.css">
    <link rel="shortcut icon" href="assets/images/BookFlow_Icon.svg" type="image/svg">
    <title>Home | BookFlow</title>
</head>

<body class="grid-container">
<?php include_once "templates/header.php" ?>
<main class="grid-container">
    <div class="large-container">
        <h1 class="text-large-bold">Herzlich willkommen</h1>
        <p class="text-medium-normal">bei <strong>BookFlow</strong>, Ihrem online Buchantiquariat</p>
        <a href="/books.php" class="big-button" id="stoebern-button">Bücher stöbern</a>
    </div>
</main>
<?php include_once "templates/footer.php"?>
</body>
</html>
