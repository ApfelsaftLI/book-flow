<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $_SESSION = [];
    $_SESSION["user"] = ["admin" => "true", "name" => "Bernardini", "firstName" => "Vincent"];
}
include 'includes/db.php'
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
            <form method="GET" action="<?= $_SERVER['PHP_SELF']; ?>">
                <div class="search-container">
                    <div class="search-bar-container">
                        <?php if (isset($_GET["search"])) {
                            echo '<input class="search-bar" type="search" name="search" id="book-search" placeholder="Suche..." value="' . $_GET["search"] . '">';
                        } else
                            echo '<input class="search-bar" type="search" name="search" id="book-search" placeholder="Suche...">';
                        ?>
                        <div class="search-icon">🔍</div>
                    </div>
                    <div class="dropdown">
                        <div class="filter-container">
                            <select class="filter" name="filter">
                                <option value="">Filter</option>
                                <option value="id">id</option>
                                <option value="nummer">Nummer</option>
                                <option value="">Audi</option>
                            </select>
                        </div>
                        <div class="sort-container">
                            <select class="sort" name="sort">
                                <option value="">Sortieren</option>
                                <option value="kurztitle ASC">Kurztitel aufsteigend</option>
                                <option value="kurztitle DESC">Kurztitel absteigend</option>
                                <option value="">Audi</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
        <?php
        include_once "includes/functions.php";
        /* 
        Check if filter is set. If not it will be set to kurztitle to avoid errors and have an 
        output. If it is set, the set value will be given to the query.
        */
        if (isset($_GET['sort'])) {
            $sortInput = $_GET['sort'];
        } else {
            $sortInput = 'kurztitle ASC';
        }
        /* 
        Check if filter is set. If not it will be set to kurztitle to avoid errors and have an 
        output. If it is set, the set value will be given to the query.
        */
        if (isset($_GET['filter'])) {
            $filterInput = $_GET['filter'];
        } else {
            $filterInput = 'kurztitle';
        }

        // Check if the search input is submitted
        if (isset($_GET['search'])) {
            $searchInput = htmlspecialchars(trim($_GET['search']));
            listBooks($searchInput, $filterInput, $sortInput); // Pass the search input to the searchBook function
        } else {
            // If no search input is submitted, pass an empty string to the searchBook function
            listBooks("", $filterInput, $sortInput);
        }
        ?>
    </main>
    <?php include_once "templates/footer.php" ?>

</body>

</html>