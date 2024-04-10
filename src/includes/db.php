<?php
$username = 'root';
$password = 'root';
$server = 'book-flow-mysql';
$connection = null;
$_SESSION["dbConnection"] = false;

try {
    $connection = new PDO("mysql:host=$server;port=3306;dbname=book_DB", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $_SESSION["dbConnection"] = true;

} catch (PDOException $e) {
    echo "<div class='error'><b>Die Verbindung zur Datenbank konnte nicht hergestellt werden:</b><p>" . $e->getMessage() . "</p></div>";
    $_SESSION["dbConnection"] = false;
}


function listBooks(string $searchQuery, string $filterInput, string $sortInput, bool $isNummeric)
{
    if (!$_SESSION["dbConnection"])
        return;
    require_once 'db.php';
    global $connection;
    if ($isNummeric) {
        $sqlQuery = "SELECT kurztitle, nummer, id FROM buecher WHERE $filterInput = :searchQuery ORDER BY $sortInput";
        $statement = $connection->prepare($sqlQuery);
        $statement->bindParam(':searchQuery', $searchQuery, PDO::PARAM_INT);
    } else {
        $sqlQuery = "SELECT kurztitle, nummer, id FROM buecher WHERE $filterInput LIKE :searchInput ORDER BY $sortInput";
        $statement = $connection->prepare($sqlQuery);
        $searchInput = $searchQuery . '%';
        $statement->bindParam(':searchInput', $searchInput, PDO::PARAM_STR);
    }
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        echo "Kurztitle: " . $row['kurztitle'] . ", Number: " . $row['nummer'] . ", ID:" . $row['id'] . "<br>";
    }
}

function listFullUserNames()
{
    if (!$_SESSION["dbConnection"])
        return;
    require_once 'db.php';
    global $connection;
    $sql = "SELECT vorname, name from benutzer";
    foreach ($connection->query($sql) as $row) {
        echo $row['vorname'] . " " . $row['name'] . "<br/>";
    }
}

function getRandomBooks(int $amount) {
    if (!$_SESSION["dbConnection"]) return;
    global $connection;

    $sqlQuery = "SELECT kurztitle, autor FROM buecher ORDER BY RAND() LIMIT $amount";

    include_once 'functions.php';
    foreach ($connection->query($sqlQuery) as $book) {
        $book = shortenShortTitles($book);
        echo $book['kurztitle'] . " " . $book['autor'] . "<br/>";
    }
}