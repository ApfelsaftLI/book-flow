<?php
session_start();
include_once "includes/db.php";
include_once "includes/functions.php";

    $book_id = htmlspecialchars($_POST["book_id"]);
    $title = htmlspecialchars($_POST["title"]);
    $autor = htmlspecialchars($_POST["autor"]);
    $kurztitle = htmlspecialchars($_POST["kurztitle"]);
    $nummer = htmlspecialchars($_POST["nummer"]);
    $zustand = htmlspecialchars($_POST["zustand"]);
    $selectedKategorie = htmlspecialchars($_POST['kategorie']);
$result = updateBook($book_id, $title, $autor, $kurztitle, $nummer, $zustand, $selectedKategorie);
if ($result) {
    $ext = substr(strrchr($_FILES['file']['name'], "."), 1);
    $fileAccepted = checkFileExtension($ext);
    $fileSize = $_FILES['file']['size'];

    if($fileAccepted==1 && $fileSize > '82428800'){
        if (is_uploaded_file($_FILES['my_upload']['tmp_name'])){
            if(empty($_FILES['my_upload']['name'])){
            exit;
            }
            $uploadFileName = $_FILES['my_upload']['name'];
            $fileName = strtok($uploadFileName, ".");
            $fileNameComplet = $fileName . $ext;
            $dest=__DIR__.'assets/images/books'.$fileNameComplet;
            move_uploaded_file($_FILES['my_upload']['tmp_name'], $dest);
    }}

    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Redirecting...</title>
    </head>
    <body>
    <form id="redirectForm" action="book.php" method="post">
        <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
    </form>
    <script type="text/javascript">
        document.getElementById('redirectForm').submit();
    </script>
    </body>
    </html>
    <?php
} else {
    echo "Failed to update book details.";
}
?>