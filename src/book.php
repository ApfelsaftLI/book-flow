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
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assets/styles/book.css">
    <link rel="shortcut icon" href="assets/images/BookFlow_Icon.svg" type="image/svg">
    <title>Buch | BookFlow</title>
</head>
<body class="grid-container">
<?php include_once "templates/header.php" ?>
<main class="grid-container">
    <?php
    error_reporting(E_ERROR | E_PARSE);
    include_once "includes/functions.php";
    include_once "includes/db.php";
    $book_id = $_POST["book_id"];
    $result = listBook($book_id);
    $nummer = $result['nummer'];
    $id = $result['id'];
    $katalog = $result['katalog'];
    $nummer = $result['nummer'];
    $kurztitle = $result['kurztitle'];
    $kategorie = $result['kategorie'];
    $verkauft = $result['verkauft'];
    $kaufer = $result['kaufer'];
    $autor = $result['autor'];
    $title = $result['title'];
    $sprache = $result['sprache'];
    $foto = $result['foto'];
    $verfasser = $result['verfasser'];
    $zustand = $result['zustand'];
    ?>
    <div class="book-box">
        <?php if(isset($foto)): ?>
            <img src="assets/images/<?php echo $foto; ?>" alt="Book Cover">
        <?php endif; ?>
        <?php if(isset($kurztitle)): ?>
            <h2><?php echo $kurztitle; ?></h2>
        <?php endif; ?>
        <?php if(isset($autor)): ?>
            <p><?php echo $autor; ?></p>
        <?php endif; ?>
        <div class="line"></div>
    </div>
</main>
<?php include_once "templates/footer.php" ?>
</body>
</html>
