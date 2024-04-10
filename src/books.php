<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $_SESSION = [];
    $_SESSION["user"] = ["admin" => "true", "name" => "Bernardini", "vorname" => "Vincent"];
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
    <script>
        //some js so there is no submitbutton needed
        document.addEventListener('DOMContentLoaded', function() {
            const filterSelect = document.querySelector('.filter')
            const sortSelect = document.querySelector('.sort')

            function submitForm() {
                document.querySelector('form').submit()
            }

            filterSelect.addEventListener('change', function() {
                submitForm()
            })

            sortSelect.addEventListener('change', function() {
                submitForm()
            })
        })
    </script>

</head>

<body class="grid-container">
<?php include_once "templates/header.php" ?>
<main class="grid-container">
    <div class="search-container">
        <form method="GET" action="<?= $_SERVER['PHP_SELF']; ?>">
            <div class="search-container">
                <div class="search-bar-container">
                    <?php if (isset($_GET['search'])) {
                        echo '<input class="search-bar" type="search" name="search" id="book-search" placeholder="Suche..." value="' . $_GET["search"] . '">';
                    } else
                        echo '<input class="search-bar" type="search" name="search" id="book-search" placeholder="Suche...">';
                    ?>
                    <button class="search-icon" type="submit"></button>
                </div>
                <div class="dropdown">
                    <input type="hidden" name="filter" id="filter-hidden"
                           value="<?= isset($_GET['filter']) ? $_GET['filter'] : 'default'; ?>">
                    <input type="hidden" name="sort" id="sort-hidden"
                           value="<?= isset($_GET['sort']) ? $_GET['sort'] : 'default'; ?>">
                    <div class="filter-container">
                        <select class="filter" onchange="updateHiddenValue('filter')"
                                name="filter">
                            <option
                                value="default" <?= isset($_GET['filter']) && $_GET['filter'] == 'default' ? 'selected' : ''; ?>>
                                Filter
                            </option>
                            <option
                                value="id" <?= isset($_GET['filter']) && $_GET['filter'] == 'id' ? 'selected' : ''; ?>>
                                ID
                            </option>
                            <option
                                value="katalog" <?= isset($_GET['filter']) && $_GET['filter'] == 'katalog' ? 'selected' : ''; ?>>
                                Katalog
                            </option>
                            <option
                                value="nummer" <?= isset($_GET['filter']) && $_GET['filter'] == 'nummer' ? 'selected' : ''; ?>>
                                Nummer
                            </option>
                            <option
                                value="default" <?= isset($_GET['filter']) && $_GET['filter'] == 'default' ? 'selected' : ''; ?>>
                                Kurztitel
                            </option>
                            <option
                                value="kategorie" <?= isset($_GET['filter']) && $_GET['filter'] == 'kategorie' ? 'selected' : ''; ?>>
                                Kategorie
                            </option>
                            <option
                                value="verkauft" <?= isset($_GET['filter']) && $_GET['filter'] == 'verkauft' ? 'selected' : ''; ?>>
                                Verkauft
                            </option>
                            <option
                                value="autor" <?= isset($_GET['filter']) && $_GET['filter'] == 'autor' ? 'selected' : ''; ?>>
                                Kaufer
                            </option>
                            <option
                                value="title" <?= isset($_GET['filter']) && $_GET['filter'] == 'title' ? 'selected' : ''; ?>>
                                Title
                            </option>
                            <option
                                value="sprache" <?= isset($_GET['filter']) && $_GET['filter'] == 'sprache' ? 'selected' : ''; ?>>
                                Sprache
                            </option>
                            <option
                                value="verfasser" <?= isset($_GET['filter']) && $_GET['filter'] == 'verfasser' ? 'selected' : ''; ?>>
                                Verfasser
                            </option>
                            <option
                                value="zustand" <?= isset($_GET['filter']) && $_GET['filter'] == 'zustand' ? 'selected' : ''; ?>>
                                Zustand
                            </option>
                        </select>
                    </div>
                    <div class="sort-container">
                        <select class="sort" onchange="updateHiddenValue('sort')" name="sort">
                            <option
                                value="default" <?= isset($_GET['sort']) && $_GET['sort'] == 'default' ? 'selected' : ''; ?>>
                                Sortieren
                            </option>
                            <option
                                value="id ASC" <?= isset($_GET['sort']) && $_GET['sort'] == 'id ASC' ? 'selected' : ''; ?>>
                                ID aufsteigend
                            </option>
                            <option
                                value="id DESC" <?= isset($_GET['sort']) && $_GET['sort'] == 'id DESC' ? 'selected' : ''; ?>>
                                ID absteigend
                            </option>
                            <option
                                value="katalog ASC" <?= isset($_GET['sort']) && $_GET['sort'] == 'katalog ASC' ? 'selected' : ''; ?>>
                                Katalog aufsteigend
                            </option>
                            <option
                                value="katalog DESC" <?= isset($_GET['sort']) && $_GET['sort'] == 'katalog DESC' ? 'selected' : ''; ?>>
                                Katalog absteigend
                            </option>
                            <option
                                value="nummer ASC" <?= isset($_GET['sort']) && $_GET['sort'] == 'nummer ASC' ? 'selected' : ''; ?>>
                                Nummer aufsteigend
                            </option>
                            <option
                                value="nummer DESC" <?= isset($_GET['sort']) && $_GET['sort'] == 'nummer DESC' ? 'selected' : ''; ?>>
                                Nummer absteigend
                            </option>
                            <option
                                value="kurztitle ASC" <?= isset($_GET['sort']) && $_GET['sort'] == 'kurztitle ASC' ? 'selected' : ''; ?>>
                                Kurztitel aufsteigend
                            </option>
                            <option
                                value="kurztitle DESC" <?= isset($_GET['sort']) && $_GET['sort'] == 'kurztitle DESC' ? 'selected' : ''; ?>>
                                Kurztitel absteigend
                            </option>
                            <option
                                value="kategorie ASC" <?= isset($_GET['sort']) && $_GET['sort'] == 'kategorie ASC' ? 'selected' : ''; ?>>
                                Kategorie aufsteigend
                            </option>
                            <option
                                value="kategorie DESC" <?= isset($_GET['sort']) && $_GET['sort'] == 'kategorie DESC' ? 'selected' : ''; ?>>
                                Kategorie absteigend
                            </option>
                            <option
                                value="verkauft ASC" <?= isset($_GET['sort']) && $_GET['sort'] == 'verkauft ASC' ? 'selected' : ''; ?>>
                                Verkauft aufsteigend
                            </option>
                            <option
                                value="verkauft DESC" <?= isset($_GET['sort']) && $_GET['sort'] == 'verkauft DESC' ? 'selected' : ''; ?>>
                                Verkauft absteigend
                            </option>
                            <option
                                value="autor ASC" <?= isset($_GET['sort']) && $_GET['sort'] == 'autor ASC' ? 'selected' : ''; ?>>
                                Käufer aufsteigend
                            </option>
                            <option
                                value="autor DESC" <?= isset($_GET['sort']) && $_GET['sort'] == 'autor DESC' ? 'selected' : ''; ?>>
                                Käufer absteigend
                            </option>
                            <option
                                value="title ASC" <?= isset($_GET['sort']) && $_GET['sort'] == 'title ASC' ? 'selected' : ''; ?>>
                                Title aufsteigend
                            </option>
                            <option
                                value="title DESC" <?= isset($_GET['sort']) && $_GET['sort'] == 'title DESC' ? 'selected' : ''; ?>>
                                Title absteigend
                            </option>
                            <option
                                value="sprache ASC" <?= isset($_GET['sort']) && $_GET['sort'] == 'sprache ASC' ? 'selected' : ''; ?>>
                                Sprache aufsteigend
                            </option>
                            <option
                                value="sprache DESC" <?= isset($_GET['sort']) && $_GET['sort'] == 'sprache DESC' ? 'selected' : ''; ?>>
                                Sprache absteigend
                            </option>
                            <option
                                value="verfasser ASC" <?= isset($_GET['sort']) && $_GET['sort'] == 'verfasser ASC' ? 'selected' : ''; ?>>
                                Verfasser aufsteigend
                            </option>
                            <option
                                value="verfasser DESC" <?= isset($_GET['sort']) && $_GET['sort'] == 'verfasser DESC' ? 'selected' : ''; ?>>
                                Verfasser absteigend
                            </option>
                            <option
                                value="zustand ASC" <?= isset($_GET['sort']) && $_GET['sort'] == 'zustand ASC' ? 'selected' : ''; ?>>
                                Zustand aufsteigend
                            </option>
                            <option
                                value="zustand DESC" <?= isset($_GET['sort']) && $_GET['sort'] == 'zustand DESC' ? 'selected' : ''; ?>>
                                Zustand absteigend
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </form>

        <script>
            //some js to not reset the filter or sort inputs
            function updateHiddenValue(type) {
                const selectedValue = document.querySelector(`.${type}`).value
                document.getElementById(`${type}-hidden`).value = selectedValue
            }
        </script>

    </div>
    <div class="result-container">
        <?php
        error_reporting(E_ERROR | E_PARSE);
        include_once "includes/functions.php";
        /* 
        Check if sort is set. If not it will be set to kurztitle to avoid errors and have an 
        output. If it is set, the set value will be given to the query.
        */
        if ($_GET['sort'] !== 'default') {
            $sortInput = $_GET['sort'];
        } else {
            $sortInput = 'kurztitle ASC';
        }

        /* 
        Check if filter is set. If not it will be set to kurztitle to avoid errors and have an 
        output. If it is set, the set value will be given to the query.
        */
        if ($_GET['filter'] !== 'default') {
            $filterInput = $_GET['filter'];

        } else {
            $filterInput = 'kurztitle';
        }
        if ($filterInput == NULL) {
            $filterInput = "kurztitle";
        }
        if ($sortInput == NULL) {
            $sortInput = "kurztitle ASC";
        }


        $nummericFilters = ['id', 'nummer', 'katalog', 'kategorie', 'verfasser'];
        $isNummeric = false;
        if (in_array($filterInput, $nummericFilters)) {
            $isNummeric = true;
        } else {
            $isNummeric = false;
        }

        // Check if the search input is submitted
        if (isset($_GET['search'])) {
            $searchInput = htmlspecialchars(trim($_GET['search']));
            listBooks($searchInput, $filterInput, $sortInput, $isNummeric);
        } else {
            listBooks("", $filterInput, $sortInput, $isNummeric);
        }
        ?>
    </div>
</main>
<?php include_once "templates/footer.php" ?>

</body>

</html>