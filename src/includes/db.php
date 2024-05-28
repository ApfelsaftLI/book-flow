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

function updateAdminStatus($id, $status): bool {
    if (!$_SESSION["dbConnection"]) return false;
    global $connection;

    $sqlQuery = "UPDATE benutzer
        SET admin = :status WHERE ID = :id";


    $statement = $connection->prepare($sqlQuery);

    $statement->bindParam('status', $status, PDO::PARAM_INT);
    $statement->bindParam('id', $id, PDO::PARAM_INT);
    return $statement->execute();
}

function getUserArray(string $searchQuery, int $page): array {
    if (!$_SESSION["dbConnection"]) return [];
    global $connection;

    $displacement = $page * 8 - 8;
    $searchQuery = "%$searchQuery%";

    $sqlQuery = "SELECT ID, benutzername, email, name, vorname, admin 
                FROM benutzer
                WHERE ID LIKE :search
                OR benutzername LIKE :search
                OR email LIKE :search
                OR name LIKE :search
                OR vorname LIKE :search
                LIMIT 8 OFFSET :displacement";


    $statement = $connection->prepare($sqlQuery);

    $statement->bindParam('search', $searchQuery, PDO::PARAM_STR);
    $statement->bindParam('displacement', $displacement, PDO::PARAM_INT);
    $statement->execute();

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}

function getCustomerArray(string $searchQuery, int $page): array {
    if (!$_SESSION["dbConnection"]) return [];
    global $connection;

    $displacement = $page * 8 - 8;
    $searchQuery = "%$searchQuery%";

    $sqlQuery = "SELECT *
                FROM kunden
                WHERE kid LIKE :search
                OR email LIKE :search
                OR name LIKE :search
                OR vorname LIKE :search
                LIMIT 8 OFFSET :displacement";


    $statement = $connection->prepare($sqlQuery);

    $statement->bindParam('search', $searchQuery, PDO::PARAM_STR);
    $statement->bindParam('displacement', $displacement, PDO::PARAM_INT);
    $statement->execute();

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}

function getUserPages(string $searchQuery): int {
    if (!$_SESSION["dbConnection"]) return [];
    global $connection;

    $sqlQuery = "SELECT COUNT(ID) AS pages
                FROM benutzer
                WHERE ID LIKE '%$searchQuery%'
                OR benutzername LIKE '%$searchQuery%'
                OR email LIKE '%$searchQuery%'
                OR name LIKE '%$searchQuery%'
                OR vorname LIKE '%$searchQuery%'";


    $statement = $connection->prepare($sqlQuery);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    return ceil($results[0]['pages'] / 8);
}

function getCustomerPages(string $searchQuery): int {
    if (!$_SESSION["dbConnection"]) return [];
    global $connection;

    $sqlQuery = "SELECT COUNT(kid) AS pages
                FROM kunden
                WHERE kid LIKE '%$searchQuery%'
                OR email LIKE '%$searchQuery%'
                OR name LIKE '%$searchQuery%'
                OR vorname LIKE '%$searchQuery%'";


    $statement = $connection->prepare($sqlQuery);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    return ceil($results[0]['pages'] / 8);
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
    <img src='assets/images/books/" . $row['foto'] . "' alt='Book cover of " . $row['kurztitle'] . "'>
    <div class='info-text'>
        <h2>" . $row['kurztitle'] . "</h2>
        <p>" . $row['autor'] . "</p>
        <form action='book.php' method='POST'>
            <input type='hidden' name='book_id' value='" . $row['id'] . "'>
            <input type='hidden' name='searchQuery' value='" . $searchQuery . "'>
            <input type='hidden' name='filterInput' value='" . $filterInput . "'>
            <input type='hidden' name='sortInput' value='" . $sortInput . "'>
            <input type='hidden' name='isNumeric' value='" . $isNumeric . "'>
            <button class='send-value-button'>Details</button>
        </form>
    </div>
</div>";
        $formattedResults[] = $resultString;
    }
    return ['results' => $formattedResults, 'count' => $resultCount];
}

function listBook($bookID) {
    $bookID = intval($bookID);
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
        'foto' => $foto,
        'verfasser' => $verfasser,
        'zustand' => $zustand,
    ];
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
                <img src='assets/images/books/" . $book['foto'] . "' alt='gugus'>
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

function getKategorie($kategorie) {
    $kategorie = intval($kategorie);
    $resultKateorien = [];
    $resultCount = 0;
    if (!$_SESSION["dbConnection"])
        echo "Connection Failed";
    require_once 'db.php';
    global $connection;
    $sqlQuery = "SELECT kategorie FROM kategorien where id = " . "$kategorie";
    $statement = $connection->prepare($sqlQuery);
    $statement->execute();
    $resultKateorien = $statement->fetch(PDO::FETCH_ASSOC);
    return ["kategorie" => $resultKateorien['kategorie']];
}

function getImage($book_id)
{
    if (!$_SESSION["dbConnection"])
        echo "Connection Failed";
    require_once 'db.php';
    global $connection;
    $sqlQuery = "SELECT foto FROM buecher where id = " . "$book_id";
    $statement = $connection->prepare($sqlQuery);
    $statement->execute();
    $resultKateorien = $statement->fetch(PDO::FETCH_ASSOC);
    return ["foto" => $resultKateorien['foto']];
}

function updateBook($book_id, $title, $autor, $kurztitle, $nummer, $zustand, $selectedKategorie, $fileNameComplet) {
    global $connection;
    try {
        $sqlQuery = "UPDATE buecher SET 
                     title = :title, 
                     autor = :autor,
                     kurztitle = :kurztitle,
                     nummer = :nummer,
                     zustand = :zustand,
                    kategorie = :selectedKategorie,
                    foto  = :fileNameComplet
                     WHERE id = :book_id";
        $statement = $connection->prepare($sqlQuery);

        $statement->bindParam(':title', $title, PDO::PARAM_STR);
        $statement->bindParam(':autor', $autor, PDO::PARAM_STR);
        $statement->bindParam(':kurztitle', $kurztitle, PDO::PARAM_STR);
        $statement->bindParam(':nummer', $nummer, PDO::PARAM_STR);
        $statement->bindParam(':zustand', $zustand, PDO::PARAM_STR);
        $statement->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        $statement->bindParam(':selectedKategorie', $selectedKategorie, PDO::PARAM_INT);
        $statement->bindParam(':fileNameComplet', $fileNameComplet, PDO::PARAM_STR);

        $success = $statement->execute();

        return $success;
    } catch (PDOException $e) {
        return false;
    }
}

function addBook(string $title, string $autor, string $kurztitle, int $nummer, string $zustand, int $selectedKategorie, string $fileNameComplet, int $katalog, int $kaufer, string $sprachen, int $verfassung, int $verkauft) {
    global $connection;

    try {
        $sqlQuery = "INSERT INTO buecher (title, autor, kurztitle, nummer, zustand, kategorie, foto, katalog, kaufer, sprache, verfasser, verkauft) 
                     VALUES (:title, :autor, :kurztitle, :nummer, :zustand, :selectedKategorie, :fileNameComplet, :katalog, :kaufer, :sprachen, :verfassung, :verkauft)";
        $statement = $connection->prepare($sqlQuery);

        $statement->bindParam(':title', $title);
        $statement->bindParam(':autor', $autor);
        $statement->bindParam(':kurztitle', $kurztitle);
        $statement->bindParam(':nummer', $nummer, PDO::PARAM_INT);
        $statement->bindParam(':zustand', $zustand);
        $statement->bindParam(':selectedKategorie', $selectedKategorie, PDO::PARAM_INT);
        $statement->bindParam(':fileNameComplet', $fileNameComplet);
        $statement->bindParam(':katalog', $katalog, PDO::PARAM_INT);
        $statement->bindParam(':kaufer', $kaufer, PDO::PARAM_INT);
        $statement->bindParam(':sprachen', $sprachen);
        $statement->bindParam(':verfassung', $verfassung, PDO::PARAM_INT);
        $statement->bindParam(':verkauft', $verkauft, PDO::PARAM_INT);

        $success = $statement->execute();

        $idQuery = "SELECT MAX(id) as max_id FROM buecher";
        $idStatement = $connection->prepare($idQuery);
        $idStatement->execute();
        $result = $idStatement->fetch(PDO::FETCH_ASSOC);


        return $result['max_id'];
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}


function deleteBook($book_id) {
    global $connection;
    try {
        $sqlQuery = "DELETE FROM buecher WHERE id = :book_id";
        $statement = $connection->prepare($sqlQuery);
        $statement->bindParam(':book_id', $book_id, PDO::PARAM_INT);

        $success = $statement->execute();

        return $success;
    } catch (PDOException $e) {
        return false;
    }
}


