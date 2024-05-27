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
    <form action="update_book.php" method="post" class="editForm" enctype="multipart/form-data">
        <input type="hidden" name="book_id" value="<?php echo $id; ?>">

        <label for="title">Title:</label>
        <textarea id="title" name="title"><?php echo htmlspecialchars($title); ?></textarea><br>

        <label for="kurztitle">Kurztitle:</label>
        <textarea id="kurztitle" name="kurztitle"><?php echo htmlspecialchars($kurztitle); ?></textarea><br>

        <label for="autor">Autor:</label>
        <textarea id="autor" name="autor"><?php echo htmlspecialchars($autor); ?></textarea><br>

        <label for="nummer">Nummer:</label>
        <input type="text" id="nummer" name="nummer" value="<?php echo htmlspecialchars($nummer); ?>"><br>

        <label for="lol">Bild:</label><br>
        <label for="image" class="image">Klicken Sie hier um ein Bild hochzuladen</label>
        <input type="file" id="image" name="file"><br>

        <label for="kategorie">Kategorie:</label>
        <select name="kategorie" id="kategorie">
            <option value="<?php echo $kategorie; ?>"><?php echo $kategorieClean; ?></option>
            <?php
            for ($i = 1; $i <= 14; $i++) {
                $resultKateorien = getKategorie($i);
                $kategorieClean = $resultKateorien['kategorie'];
                echo '<option value="' . $i . '">' . htmlspecialchars($kategorieClean) . '</option>';
            }
            ?>
        </select>

        <label for="zustand">Zustand:</label>
        <select name="zustand" id="zustand">
            <option value="<?php echo htmlspecialchars($zustand); ?>"><?php echo htmlspecialchars($zustandSelect); ?></option>
            <option value="G">Gut</option>
            <option value="M">Mittel</option>
            <option value="S">Schlecht</option>
        </select>
        <input type="submit" value="Update">
    </form>
</main>
<?php include_once "templates/footer.php"; ?>
</body>
</html>
