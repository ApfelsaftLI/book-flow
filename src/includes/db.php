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


function listBooks(string $searchQuery, string $filterInput, string $sortInput, bool $isNumeric) {
    $results = [];
    $resultCount = 0; // Initialize result count
    if (!$_SESSION["dbConnection"])
        return ['results' => $results, 'count' => $resultCount];
    require_once 'db.php';
    global $connection;
    if ($isNumeric) {
        $sqlQuery = "SELECT kurztitle, autor, foto, id FROM buecher WHERE $filterInput = :searchQuery ORDER BY $sortInput";
        $statement = $connection->prepare($sqlQuery);
        $statement->bindParam(':searchQuery', $searchQuery, PDO::PARAM_INT);
    } else {
        $sqlQuery = "SELECT kurztitle, autor, foto, id FROM buecher WHERE $filterInput LIKE :searchInput ORDER BY $sortInput";
        $statement = $connection->prepare($sqlQuery);
        $searchInput = $searchQuery . '%';
        $statement->bindParam(':searchInput', $searchInput, PDO::PARAM_STR);
    }
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    $resultCount = count($results);
    $formattedResults = [];
    foreach ($results as &$row) {
        $row = shortenShortTitlesShorter($row);
        $row = shortenAutor($row);
        $resultString = "
<div>
    <img src='assets/images/" . $row['foto'] . "' alt='Book cover of " . $row['kurztitle'] . "'>
    <div class='info-text'>
        <h2>" . $row['kurztitle'] . "</h2>
        <p>" . $row['autor'] . "</p>
        <form action='book.php' method='POST'>
            <input type='hidden' name='book_id' value='" . $row['id'] . "'>
            <button class='send-value-button'>Details</button>
        </form>
    </div>
</div>";
        $formattedResults[] = $resultString;
    }
    return ['results' => $formattedResults, 'count' => $resultCount];
}


function listBook(int $bookID) {
    $result = [];
    $resultCount = 0;
    if (!$_SESSION["dbConnection"])
        echo "Connection Failed";
    require_once 'db.php';
    global $connection;
    $sqlQuery = "SELECT * FROM buecher WHERE id = :bookID";
    $statement = $connection->prepare($sqlQuery);
    $statement->bindParam(':bookID', $bookID, PDO::PARAM_INT);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $id = $result['id'];
    $katalog = $result['katalog'];
    $nummer = $result['nummer'];
    $kurztitle = $result['kurztitle'];
    $kategorie = $result['kategorie'];
    $verkauft = $result['verkauft'];
    $kaufer = $result['kaufer'];
    $autor = $result['autor'];
    $title = $result['title'];
    $sprache = $result['sprache'];
    $foto = $result['foto'];
    $verfasser = $result['verfasser'];
    $zustand = $result['zustand'];

    return [
        'id' => $id,
        'katalog' => $katalog,
        'nummer' => $nummer,
        'kurztitle' => $kurztitle,
        'kategorie' => $kategorie,
        'verkauft' => $verkauft,
        'kaufer' => $kaufer,
        'autor' => $autor,
        'title' => $title,
        'sprache' => $sprache,
        'foto' => $foto,
        'verfasser' => $verfasser,
        'zustand' => $zustand,
    ];
}

function listFullUserNames() {
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

    $sqlQuery = "SELECT kurztitle, autor, foto, id FROM buecher ORDER BY RAND() LIMIT $amount";

    include_once 'functions.php';
    foreach ($connection->query($sqlQuery) as $book) {
        $book = shortenShortTitlesShorter($book);
        $book = shortenAutor($book);
        echo "<div class='book-carousel-box'>
                <img src='assets/images/" . $book['foto'] . "' alt='gugus'>
                <div class='info-text'>
                    <h2>" . $book['kurztitle'] . "</h2>
                    <p>" . $book['autor'] . "</p>
                    <form action='book.php' method='POST'>
                        <input type='hidden' name='book_id' value='" . $book['id'] . "'>
                        <button class='send-value-button'>Details</button>
                    </form>
                </div>
               </div>";
    }
}

function getPasswordHash(string $email): string {
    if (!$_SESSION["dbConnection"]) return false;
    global $connection;

    $sqlQuery = "SELECT passwort FROM benutzer WHERE email = :email LIMIT 1";
    $statement = $connection->prepare($sqlQuery);
    $statement->bindParam('email', $email, PDO::PARAM_STR);
    if (!$statement->execute()) return false;
    return $statement->fetchColumn();
}

function getUser(string $email) {
    if (!$_SESSION["dbConnection"]) return false;
    global $connection;

    $sqlQuery = "SELECT admin, name, vorname FROM benutzer WHERE email = :email LIMIT 1";
    $statement = $connection->prepare($sqlQuery);
    $statement->bindParam('email', $email, PDO::PARAM_STR);
    if (!$statement->execute()) return false;
    $result = $statement->fetch();

    return ["admin" => translateAdmin($result), "name" => $result['name'], "vorname" => $result['vorname']];
}

function translateAdmin(array $user) {
    if (empty($user['admin'])) return "false";
    return "true";
}