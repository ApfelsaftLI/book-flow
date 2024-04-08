<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $_SESSION = [];
    $_SESSION["user"] = ["admin" => "true", "name" => "Bernardini", "firstName" => "Vincent"];
}
?>
<!doctype html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assets/styles/books.css">
    <link rel="shortcut icon" href="assets/images/BookFlow_Icon.svg" type="image/svg">
    <title>Bücher | BookFlow</title>
</head>

<body class="grid-container">
    <?php include_once "templates/header.php" ?>
    <main class="grid-container">
        <div class="search-container">
            <form method="GET" action="">
                <div class="search-container">
                    <div class="search-bar-container">
                        <input class="search-bar" type="search" name="search" id="book-search" placeholder="Suche..."> 
                        <div class="search-icon">🔍</div>
                    </div>
                    <div class="dropdown">
                        <div class="filter-container">
                            <select class="filter" name="filter">
                                <option value="Filter">Filter</option>
                                <option value="saab">Saab</option>
                                <option value="fiat">Fiat</option>
                                <option value="audi">Audi</option>
                            </select>
                        </div>
                        <div class="sort-container">
                            <select class="sort" name="sort">
                                <option value="Sortieren">Sortieren</option>
                                <option value="saab">Saab</option>
                                <option value="fiat">Fiat</option>
                                <option value="audi">Audi</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php
        include_once "includes/functions.php";
        searchBook("")
        ?>
    </main>
    <?php include_once "templates/footer.php" ?>
</body>

</html>