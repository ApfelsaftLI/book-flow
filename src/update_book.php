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