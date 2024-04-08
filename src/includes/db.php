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


function listBooks(string $kurztitleSearchQuery)
{
    if (!$_SESSION["dbConnection"]) return;
    require_once 'db.php';
    global $connection;
    $sqlQuery = 'SELECT kurztitle, nummer, id FROM buecher WHERE kurztitle LIKE :searchInput';
    $statement = $connection->prepare($sqlQuery);
    $statement->bindValue(':searchInput', $kurztitleSearchQuery . '%', PDO::PARAM_STR);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        echo "Kurztitle: " . $row['kurztitle'] . ", Number: " . $row['nummer'] . ", ID:" . $row['id'] . "<br>";
    }
}

function listFullUserNames()
{
    if (!$_SESSION["dbConnection"]) return;
    require_once 'db.php';
    global $connection;
    $sql = "SELECT vorname, name from benutzer";
    foreach ($connection->query($sql) as $row) {
        echo $row['vorname'] . " " . $row['name'] . "<br/>";
    }
}