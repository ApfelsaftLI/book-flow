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
    <link rel="stylesheet" href="assets/styles/profile.css">
    <link rel="shortcut icon" href="assets/images/BookFlow_Icon.svg" type="image/svg">
    <title>Profil | BookFlow</title>
    <script>window.location.href = '/'</script>
</head>
<body class="grid-container">
<?php include_once "templates/header.php" ?>
<main class="grid-container">
</main>
<?php include_once "templates/footer.php" ?>
</body>
</html>