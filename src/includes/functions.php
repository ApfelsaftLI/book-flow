<?php
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

function getProfilePicture(array $user): string
{
    return 'https://api.dicebear.com/8.x/initials/svg?seed=' . getFirstLetter($user["firstName"]) . getFirstLetter($user["name"]) . $user["firstName"] . $user["name"];
}

function getFirstLetter(string $str)
{
    return substr($str, 0, 1);
}

function searchBosok(string $searchInput){
    require_once 'db.php';
    if (!$_SESSION["dbConnection"]) return;
    global $connection;
    echo print_r($connection);
    $sql = 'FROM buecher SELECT kurztitle, nummer WHERE kurztitle LIKE "' . $searchInput .'%"';
    foreach ($connection->query($sql) as $row) {
        echo $row['kurztitel'] . " " . $row['nummer'] . "<br/>";
    }
}
function searchBook(string $searchInput){
    $username = 'root';
    $password = 'root';
    $server = 'book-flow-mysql';
    require_once 'db.php';
    if (!$_SESSION["dbConnection"]) return;
    global $connection;
    $connection = new PDO("mysql:host=$server;port=3306;dbname=book_DB", $username, $password);
    echo print_r($connection); 

    $sql = 'SELECT kurztitle, nummer FROM buecher WHERE kurztitle LIKE :searchInput'; // Query
    $statement = $connection->prepare($sql); //prepare query
    $statement->bindValue(':searchInput', $searchInput . '%', PDO::PARAM_STR); // bind parameter
    $statement->execute();  //execute query
    $results = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch results
    echo print_r($connection);
    foreach ($results as $row) {
        echo "Kurztitle: " . $row['kurztitle'] . ", Number: " . $row['nummer'] . "<br>";
    }
}
