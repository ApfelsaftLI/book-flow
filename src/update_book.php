<?php
session_start();
include_once "includes/db.php";
include_once "includes/functions.php";

    $book_id = $_POST["book_id"];
    $title = $_POST["title"];
    $autor = $_POST["autor"];
    $kurztitle = $_POST["kurztitle"];
    $nummer = $_POST["nummer"];
    $zustand = $_POST["zustand"];
$result = updateBook($book_id, $title, $autor, $kurztitle, $nummer, $zustand);
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