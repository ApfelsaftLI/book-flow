<?php
session_start()
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
include_once "includes/functions.php";
include_once "includes/db.php";
$id = $_GET["book_id"];
$id = htmlspecialchars($id);
$id = intval($id);
$result = listBook($id);
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

<form action="update_book.php" method="post" class="editForm">
    <input type="hidden" name="book_id" value="<?php echo $id; ?>">

    <label for="title">Title:</label>
    <textarea id="title" name="title"><?php echo $title; ?></textarea><br>

    <label for="kurztitle">Kurztitle:</label>
    <textarea id="kurztitle" name="kurztitle"><?php echo $kurztitle; ?></textarea><br>

    <label for="autor">Autor:</label>
    <textarea id="autor" name="autor"><?php echo $autor; ?></textarea><br>

    <label for="nummer">Nummer:</label>
    <input type="text" id="nummer" name="nummer" value="<?php echo $nummer; ?>"><br>

    <label for="kategorie">Kategorie:</label>
    <input type="text" id="kategorie" name="kategorie" value="<?php echo $kategorieClean; ?>"><br>

    <label for="zustand">Zustand:</label>
    <input type="text" id="zustand" name="zustand" value="<?php echo $zustand; ?>"><br>

    <input type="submit" value="Update">
</form>

</main>
<?php include_once "templates/footer.php" ?>
</body>
</html>