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
    $book_id = htmlspecialchars($_POST["book_id"]);
    $title = htmlspecialchars($_POST["title"]);
    $autor = htmlspecialchars($_POST["autor"]);
    $kurztitle = htmlspecialchars($_POST["kurztitle"]);
    $nummer = htmlspecialchars($_POST["nummer"]);
    $zustand = htmlspecialchars($_POST["zustand"]);
    $selectedKategorie = htmlspecialchars($_POST['kategorie']);

    if (!filter_var($book_id, FILTER_VALIDATE_INT)) {
        die("Invalid book ID");
    }

    $currentImage = getImage($book_id);
    $currentImage = $currentImage["foto"];

    if (isset($_FILES["file"]) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $fileAccepted = checkFileExtension($ext);
        $fileSize = $_FILES['file']['size'];

        if ($fileAccepted && $fileSize <= 8388608) {
            $uploadFileName = $_FILES['file']['name'];
            $fileName = strtok($uploadFileName, ".");
            $fileNameShortend = substr($fileName, 0, 20);
            $fileNameFinalised = str_replace(' ', '_', $fileNameShortend);
            $fileNameComplet = $fileNameFinalised . '.' . $ext;
            $dest = __DIR__ . '/assets/images/books/' . $fileNameComplet;

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
