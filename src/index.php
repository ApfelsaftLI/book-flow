<?php
//if (session_status() == PHP_SESSION_NONE) {
//    session_start();
$_SESSION = [];
$_SESSION["user"]["admin"] = $_GET["admin"];
$_SESSION["user"]["name"] = $_GET["name"];
$_SESSION["user"]["firstName"] = $_GET["firstName"];
//}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/styles/main.css">
    <title>Document</title>
</head>
<body class="grid-container">
<?php include_once "templates/header.php" ?>
<main>
</main>

<footer>

</footer>
</body>
<style> a[href="/"] {
        font-weight: bold
    }</style>
</html>
