<?php
session_start();

?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
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

    $isLoggedIn = array_key_exists("user", $_SESSION);
    $isAdmin = $isLoggedIn && $_SESSION["user"]["admin"] == "true";

    $book_id = $_POST["book_id"];
    $result = listBook($book_id);
    $id = $result['id'];
    $nummer = $result['nummer'];
    $kurztitle = $result['kurztitle'];
    $kategorie = $result['kategorie'];
    $verkauft = $result['verkauft'];
    $autor = $result['autor'];
    $title = $result['title'];
    $foto = $result['foto'];
    $zustand = $result['zustand'];
    $resultKateorien = getKategorie($kategorie);
    $kategorieClean = $resultKateorien['kategorie'];

    switch ($zustand) {
        case 'G':
            $zustand = 'gut';
            break;
        case 'M':
            $zustand = 'mittel';
            break;
        case 'S':
            $zustand = 'schlecht';
            break;
    }

    ?>
    <div class="book-box">
        <?php
        $book_id = intval($book_id);
        if ($isAdmin) {
            echo '<div class="edit-button">
            <a href="edit_book.php?book_id=' .$id . '" class="send-value-button">Edit Book</a>
        </div>';
        }
        ?>
        <?php if(isset($foto)): ?>
            <img src="assets/images/books/<?php echo $foto; ?>" alt="Book Cover">
        <?php endif; ?>
        <?php if(isset($kurztitle)): ?>
            <h2><?php echo $kurztitle; ?></h2>
        <?php endif; ?>
        <?php if(isset($autor)): ?>
            <p><?php echo $autor; ?></p>
        <?php endif; ?><br>
        <div class="line"></div>
        <h2>Beschreibung</h2>
        <div class="line"></div>
        <br>
        <?php if(isset($title)): ?>
            <p><?php echo $title; ?></p>
        <?php endif; ?><br>
        <div class="line"></div>
        <h2>Weitere Informationen</h2>
        <div class="line"></div><br>
        <?php if(isset($nummer)): ?>
            <p>Referenznummer: <?php echo $nummer; ?></p>
        <?php endif; ?>
        <?php if(isset($id)): ?>
            <p>Referenz-ID: <?php echo $id; ?></p>
        <?php endif; ?>
        <?php if(isset($nummer)): ?>
            <p>Kategorie: <?php echo $kategorieClean; ?></p>
        <?php endif; ?>
        <?php if(isset($zustand)): ?>
            <p>Das Buch ist in einem <?php echo $zustand; ?> Zustand.</p>
        <?php endif; ?>
    </div>
</main>
<?php include_once "templates/footer.php" ?>
</body>
</html>
