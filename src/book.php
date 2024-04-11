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
    $id = $result['id'];
    $nummer = $result['nummer'];
    $kurztitle = $result['kurztitle'];
    $kategorie = $result['kategorie'];
    $verkauft = $result['verkauft'];
    $autor = $result['autor'];
    $title = $result['title'];
    $sprache = $result['sprache'];
    $foto = $result['foto'];
    $zustand = $result['zustand'];

    switch ($kategorie) {
        case 1:
            $kategorie = 'Alte Drucke, Bibeln, Klassische Autoren in den Originalsprachen';
            break;
        case 2:
            $kategorie = 'Geographie und Reisen';
            break;
        case 3:
            $kategorie = 'Geschichtswissenschaften';
            break;
        case 4:
            $kategorie = 'Naturwissenschaften';
            break;
        case 5:
            $kategorie = 'Kinderbücher';
            break;
        case 6:
            $kategorie = 'Moderne Literatur und Kunst';
            break;
        case 7:
            $kategorie = 'Moderne Kunst und Künstlergraphik';
            break;
        case 8:
            $kategorie = 'Kunstwissenschaften';
            break;
        case 9:
            $kategorie = 'Architektur';
            break;
        case 10:
            $kategorie = 'Technik';
            break;
        case 11:
            $kategorie = 'Naturwissenschaften - Medizin';
            break;
        case 12:
            $kategorie = 'Ozeanien';
            break;
        case 13:
            $kategorie = 'Afrika';
            break;
        default:
            $kategorie = 'Invalid category';
            break;
    }
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
        <?php if(isset($foto)): ?>
            <img src="assets/images/<?php echo $foto; ?>" alt="Book Cover">
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
            <p>Kategorie: <?php echo $kategorie; ?></p>
        <?php endif; ?>
        <?php if(isset($sprache)): ?>
            <p>Sprache: <?php echo $sprache; ?></p>
        <?php endif; ?>
        <?php if(isset($zustand)): ?>
            <p>Das Buch ist in einem <?php echo $zustand; ?> Zustand.</p>
        <?php endif; ?>

    </div>
</main>
<?php include_once "templates/footer.php" ?>
</body>
</html>
