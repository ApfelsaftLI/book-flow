<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $_SESSION = [];
}
include 'includes/db.php'

?>
<!doctype html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assets/styles/books.css">
    <link rel="shortcut icon" href="assets/images/BookFlow_Icon.svg" type="image/svg">
    <title>Bücher | BookFlow</title>
    <script>
        //some js so there is no submitbutton needed
        document.addEventListener('DOMContentLoaded', function () {
            const filterSelect = document.querySelector('.filter')
            const sortSelect = document.querySelector('.sort')

            function submitForm() {
                document.querySelector('form').submit()
            }

            filterSelect.addEventListener('change', function () {
                submitForm()
            })

            sortSelect.addEventListener('change', function () {
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
                                    value="autor" <?= isset($_GET['filter']) && $_GET['filter'] == 'autor' ? 'selected' : ''; ?>>
                                Autor
                            </option>
                            <option
                                    value="title" <?= isset($_GET['filter']) && $_GET['filter'] == 'title' ? 'selected' : ''; ?>>
                                Title
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
                                    value="autor ASC" <?= isset($_GET['sort']) && $_GET['sort'] == 'autor ASC' ? 'selected' : ''; ?>>
                                Autor aufsteigend
                            </option>
                            <option
                                    value="autor DESC" <?= isset($_GET['sort']) && $_GET['sort'] == 'autor DESC' ? 'selected' : ''; ?>>
                                Autor absteigend
                            </option>
                            <option
                                    value="title ASC" <?= isset($_GET['sort']) && $_GET['sort'] == 'title ASC' ? 'selected' : ''; ?>>
                                Title aufsteigend
                            </option>
                            <option
                                    value="title DESC" <?= isset($_GET['sort']) && $_GET['sort'] == 'title DESC' ? 'selected' : ''; ?>>
                                Title absteigend
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
        include_once "includes/functions.php";
        error_reporting(E_ERROR | E_PARSE);
        // Sanitize user inputs
        $searchInput = isset($_GET['search']) ? htmlspecialchars(trim($_GET['search'])) : '';
        $filterInput = isset($_GET['filter']) ? $_GET['filter'] : 'kurztitle';
        $sortInput = isset($_GET['sort']) ? $_GET['sort'] : 'kurztitle ASC';

        // Validate and sanitize sort and filter inputs
        $sortInput = ($sortInput !== 'default') ? $sortInput : 'kurztitle ASC';
        $filterInput = ($filterInput !== 'default') ? $filterInput : 'kurztitle';

        // Determine if the filter is numeric
        $numericFilters = ['id', 'nummer', 'katalog', 'kategorie', 'verfasser'];
        $isNumeric = in_array($filterInput, $numericFilters);

        // Get paginated results
        $currentPage = max(1, intval($_GET['page'] ?? 1));
        $resultsPerPage = 12;
        $offset = ($currentPage - 1) * $resultsPerPage;

        $results = isset($_GET['search']) ? listBooks($searchInput, $filterInput, $sortInput, $isNumeric) : listBooks("", $filterInput, $sortInput, $isNumeric);
        $resultCount = $results['count'];
        $pagesNeeded = ceil($resultCount / $resultsPerPage);
        $currentPaginatedResults = array_slice($results['results'], $offset, $resultsPerPage);

        // Output HTML
        foreach ($currentPaginatedResults as $result) {
            echo '<div class="book-info-box">' . $result . '</div>';
        }
        if ($resultCount == 0) {
            echo '<div class="error"><h3>Leider konnte kein Resultat gefunden werden, versuchen Sie es doch mit einer neuen Suche.</h3></di>';
        }
        ?>
    </div>
    <!-- Pagination -->
    <div class="pagination">
        <?php $queryParameters = "search=". $searchInput. "&sort=" . $sortInput ."&filter=". $filterInput?>
        <a href="?page=<?php echo max(1, $currentPage - 1); ?>&<?php echo $queryParameters; ?>"
           class="pagination-btn <?php if ($currentPage == 1) echo 'disabled'; ?>">◄</a>
        <?php
        for ($i = max(1, $currentPage - 2); $i <= min($pagesNeeded, $currentPage + 2); $i++):
            ?>
            <a href="?page=<?php echo $i; ?>&<?php echo $queryParameters; ?>" <?php if ($i === $currentPage) echo 'class="active"'; ?>><?php echo $i; ?></a>
        <?php endfor; ?>
        <a href="?page=<?php echo min($pagesNeeded, $currentPage + 1); ?>&<?php echo $queryParameters; ?>"
           class="pagination-btn <?php if ($currentPage == $pagesNeeded) echo 'disabled'; ?>">►</a>
    </div>


</main>
<?php include_once "templates/footer.php" ?>

</body>

</html>