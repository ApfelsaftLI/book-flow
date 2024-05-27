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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    // Validate and sanitize inputs
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

    $maxTitleLength = 200;
    $maxAutorLength = 40;
    $maxKurztitleLength = 20;
    $maxNummerLength = 5;

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


    $fileNameComplete = "book.jpg"; // Default image
    if (isset($_FILES["file"]) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {

        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $fileAccepted = checkFileExtension($ext);
        $fileSize = $_FILES['file']['size'];

        if ($fileAccepted && $fileSize <= 8388608) {
            $uploadFileName = $_FILES['file']['name'];
            $fileName = strtok($uploadFileName, ".");
            $fileNameShortened = substr($fileName, 0, 20);
            $fileNameFinalized = str_replace(' ', '_', $fileNameShortened);
            $fileNameComplete = $fileNameFinalized . '.' . $ext;
            $dest = __DIR__ . '/assets/images/books/' . $fileNameComplete;

            if (!move_uploaded_file($_FILES['file']['tmp_name'], $dest)) {
                $errors[] = "Failed to move uploaded file.";
            }
        } else {
            $errors[] = "File not accepted or too large.";
        }
    } elseif (isset($_FILES['file']) && $_FILES['file']['error'] !== UPLOAD_ERR_NO_FILE) {
        $errors[] = "File upload error: " . $_FILES['file']['error'];
    }

    if (empty($errors)) {
        $book_id = addBook($title, $autor, $kurztitle, $nummer, $zustand, $selectedKategorie, $fileNameComplete, $katalog, $kaufer, $sprachen, $verfassung, $verkauft);
        $bookID = $book_id['max_id'];
        if ($book_id) {
            $_SESSION['success'] = "Book added successfully!";
            echo '<form id="redirectForm" method="post" action="book.php">
                    <input type="hidden" name="book_id" value="' . $book_id . '">
                  </form>
                  <script type="text/javascript">
                      document.getElementById("redirectForm").submit();
                  </script>';
            exit;
        } else {
            $errors[] = "Error adding book to database.";
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title>Redirecting...</title>
</head>
<body>
</body>
</html>
