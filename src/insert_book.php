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
    $title = htmlspecialchars($_POST["title"]);
    $autor = htmlspecialchars($_POST["autor"]);
    $kurztitle = htmlspecialchars($_POST["kurztitle"]);
    $nummer = htmlspecialchars($_POST["nummer"]);
    $zustand = htmlspecialchars($_POST["zustand"]);
    $selectedKategorie = htmlspecialchars($_POST['kategorie']);
    $fileNameComplete = "book.jpg";

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

            if (move_uploaded_file($_FILES['file']['tmp_name'], $dest)) {
                $success = addBook($title, $autor, $kurztitle, $nummer, $zustand, $selectedKategorie, $fileNameComplete);
                echo var_dump($success);
                if ($success) {
                    echo "Book added successfully!";
                } else {
                    echo "Error adding book to database.";
                }
            } else {
                echo "Failed to move uploaded file.";
            }
        } else {
            echo "File not accepted or too large.";
        }
    } else {
        addBook($title, $autor, $kurztitle, $nummer, $zustand, $selectedKategorie, $fileNameComplete);
        echo "File upload failed with error code: " . $_FILES['file']['error'];
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
