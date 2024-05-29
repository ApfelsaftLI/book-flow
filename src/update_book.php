<?php
session_start();
include_once "includes/db.php";
include_once "includes/functions.php";
$isLoggedIn = array_key_exists("user", $_SESSION);
$isAdmin = $isLoggedIn && $_SESSION["user"]["admin"] == "true";

if (!$isAdmin) {
    header("Location: index.php");
    exit;
}
//validate and sanitize inputs
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = htmlspecialchars($_POST["book_id"]);
    $title = isset($_POST["title"]) ? htmlspecialchars(trim($_POST["title"])) : '';
    $autor = isset($_POST["autor"]) ? htmlspecialchars(trim($_POST["autor"])) : '';
    $kurztitle = isset($_POST["kurztitle"]) ? htmlspecialchars(trim($_POST["kurztitle"])) : '';
    $nummer = isset($_POST["nummer"]) ? intval(trim($_POST["nummer"])) : 0;
    $zustand = isset($_POST["zustand"]) ? htmlspecialchars(trim($_POST["zustand"])) : 0;
    $selectedKategorie = isset($_POST['kategorie']) ? intval(trim($_POST['kategorie'])) : 0;
    $katalog = 0;
    $kaufer = 0;
    $sprachen = "-";
    $verfassung = 0;
    $verkauft = 0;

    // Set max lengths
    $maxTitleLength = 200;
    $maxAutorLength = 40;
    $maxKurztitleLength = 100;
    $maxNummerLength = 5;

    //check if all inputs are valid
    if (empty($title)) {
        $errors[] = "Title is required.";
    } elseif (strlen($title) > $maxTitleLength) {
        $errors[] = "Title cannot exceed $maxTitleLength characters.";
    }

    if (empty($autor)) {
        $errors[] = "Autor is required.";
    } elseif (strlen($autor) > $maxAutorLength) {
        $errors[] = "Autor cannot exceed $maxAutorLength characters.";
    }

    if (empty($kurztitle)) {
        $errors[] = "Kurztitle is required.";
    } elseif (strlen($kurztitle) > $maxKurztitleLength) {
        $errors[] = "Kurztitle cannot exceed $maxKurztitleLength characters.";
    }

    if (empty($nummer)) {
        $errors[] = "Nummer is required.";
    } elseif (strlen($nummer) > $maxNummerLength) {
        $errors[] = "Nummer cannot exceed $maxNummerLength characters.";
    }

    if (!filter_var($book_id, FILTER_VALIDATE_INT)) {
        die("Invalid book ID");
    }

    $currentImage = getImage($book_id);
    $currentImage = $currentImage["foto"];

    if (isset($_FILES["file"]) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $fileAccepted = checkFileExtension($ext);
        $fileSize = $_FILES['file']['size'];

        //check the file size, shorten the name, replace " " with "_" and the get the destination
        if ($fileAccepted && $fileSize <= 8388608) {
            $uploadFileName = $_FILES['file']['name'];
            $fileName = strtok($uploadFileName, ".");
            $fileNameShortend = substr($fileName, 0, 20);
            $fileNameFinalised = str_replace(' ', '_', $fileNameShortend);
            $fileNameComplet = $fileNameFinalised . '.' . $ext;
            $dest = __DIR__ . '/assets/images/books/' . $fileNameComplet;

            //move the file
            if (move_uploaded_file($_FILES['file']['tmp_name'], $dest)) {
                $result = updateBook($book_id, $title, $autor, $kurztitle, $nummer, $zustand, $selectedKategorie, $fileNameComplet);
            } else {
                die("Failed to move uploaded file.");
            }
        } else {
            die("File not accepted or too large.");
        }
    } else {
        $result = updateBook($book_id, $title, $autor, $kurztitle, $nummer, $zustand, $selectedKategorie, $currentImage);
    }}
    ?>
        <!DOCTYPE html>
        <html lang="de">
        <head>
            <title>Redirecting...</title>
        </head>
        <body>
        <form id="redirectForm" action="book.php" method="post">
            <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book_id); ?>">
        </form>
        <script type="text/javascript">
            document.getElementById('redirectForm').submit();
        </script>
        </body>
        </html>
