<?php
session_start();

$isLoggedIn = array_key_exists("user", $_SESSION);
$isAdmin = $isLoggedIn && $_SESSION["user"]["admin"] == "true";

if (!$isAdmin) {
    header("Location: index.php");
    exit;
}

include_once "includes/functions.php";
include_once "includes/db.php";

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
<?php include_once "templates/header.php"; ?>
<main class="grid-container">
    <form action="insert_book.php" method="post" class="editForm" enctype="multipart/form-data">
        <label for="title">Title*:</label>
        <textarea id="title" name="title" required maxlength="200"></textarea><br>

        <label for="kurztitle">Kurztitle*:</label>
        <textarea id="kurztitle" name="kurztitle" required maxlength="20"></textarea><br>

        <label for="autor">Autor*:</label>
        <textarea id="autor" name="autor" required maxlength="40"></textarea><br>

        <label for="nummer">Nummer*:</label>
        <input type="number" id="nummer" name="nummer" required maxlength="5" min="0"><br>

        <label for="lol">Bild:</label><br>
        <label for="image" class="image">Klicken Sie hier um ein Bild hochzuladen</label>
        <input type="file" id="image" name="file"><br>

        <label for="kategorie">Kategorie*:</label>
        <select name="kategorie" id="kategorie" required>
            <option value=""></option>
            <?php
            for ($i = 1; $i <= 14; $i++) {
                $resultKateorien = getKategorie($i);
                $kategorieClean = $resultKateorien['kategorie'];
                echo '<option value="' . $i . '">' . htmlspecialchars($kategorieClean) . '</option>';
            }
            ?>
        </select>

        <label for="zustand">Zustand*:</label>
        <select name="zustand" id="zustand" required>
            <option value=""></option>
            <option value="G">Gut</option>
            <option value="M">Mittel</option>
            <option value="S">Schlecht</option>
        </select>
        <p>* Required</p> <br>
        <input type="submit" value="Update">
    </form>
</main>
<?php include_once "templates/footer.php"; ?>
</body>
</html>
