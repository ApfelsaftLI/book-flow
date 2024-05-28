<?php
session_start();
error_reporting(E_ERROR | E_PARSE);

$isLoggedIn = array_key_exists("user", $_SESSION);
$isAdmin = $isLoggedIn && $_SESSION["user"]["admin"] == "true";

if (!$isAdmin) {
    header("Location: index.php");
    exit;
}

include_once "includes/functions.php";
include_once "includes/db.php";

$id = intval($_GET["book_id"]);
$result = listBook($id);

if (!$result) {
    die("Book not found.");
}

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
        $zustandSelect = 'Gut';
        break;
    case 'M':
        $zustandSelect = 'Mittel';
        break;
    case 'S':
        $zustandSelect = 'Schlecht';
        break;
    default:
        $zustandSelect = 'Unbekannt';
        break;
}
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
    <form action="update_book.php" method="post" class="editForm large-container new-user-form" enctype="multipart/form-data">
        <input type="hidden" name="book_id" value="<?php echo $id; ?>">

        <label for="title">Title*:</label>
        <textarea id="title" name="title" required maxlength="200"><?php echo htmlspecialchars($title); ?></textarea><br>

        <label for="kurztitle">Kurztitle*:</label>
        <textarea id="kurztitle" name="kurztitle" required maxlength="20"><?php echo htmlspecialchars($kurztitle); ?></textarea><br>

        <label for="autor">Autor*:</label>
        <textarea id="autor" name="autor" required maxlength="40"><?php echo htmlspecialchars($autor); ?></textarea><br>

        <label for="nummer">Nummer*:</label>
        <input type="number" id="nummer" name="nummer" value="<?php echo htmlspecialchars($nummer); ?>" required maxlength="5" min="0"><br>

        <label for="lol">Bild:</label><br>
        <label for="image" class="image">Klicken Sie hier um ein Bild hochzuladen</label>
        <input type="file" id="image" name="file"><br>

        <label for="kategorie">Kategorie*:</label>
        <select name="kategorie" id="kategorie" required>
            <option value="<?php echo $kategorie; ?>"><?php echo $kategorieClean; ?></option>
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
            <option value="<?php echo htmlspecialchars($zustand); ?>"><?php echo htmlspecialchars($zustandSelect); ?></option>
            <option value="G">Gut</option>
            <option value="M">Mittel</option>
            <option value="S">Schlecht</option>
        </select>
        <p>* Required</p> <br>
        <div class="button-container">
            <form method="post" action="book.php"><input type="hidden" name="book_id"value="<? echo $id?>"</input> <button type="submit" class="outline-button">Abbrechen</button> </input></form>
            <button type="submit" class="big-button">Buch ändern</button>
        </div>
    </form>
</main>
<?php include_once "templates/footer.php"; ?>
</body>
</html>
