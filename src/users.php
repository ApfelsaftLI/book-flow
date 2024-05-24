<?php
session_start();
include_once "includes/db.php";

$filter = $_GET['filter'] ?? "users";
$users = $filter == "users" ? getUserArray($_GET['search']) : getCustomerArray($_GET['search']);


?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/styles/styles.css">
    <link rel="stylesheet" href="assets/styles/users.css">
    <link rel="shortcut icon" href="assets/images/BookFlow_Icon.svg" type="image/svg">
    <title>Nutzer | BookFlow</title>

</head>
<body class="grid-container">
<?php include_once "templates/header.php" ?>
<main class="grid-container">
    <div class="search-container">
        <form id="search-form" method="GET" action="<?= $_SERVER['PHP_SELF'] ?>">
            <div class="search-container">
                <div class="search-bar-container">
                    <input class="search-bar" type="search" name="search" id="book-search" placeholder="Suche..."
                           value="<?= $_GET['search'] ?? '' ?>">
                    <button class="search-icon" type="submit"></button>
                </div>
                <div class="dropdown">
                    <div class="filter-container">
                        <select class="filter" onchange="this.form.submit()"
                                name="filter">
                            <option value="users" <?= $filter == 'users' ? 'selected' : '' ?>>
                                Nutzer
                            </option>

                            <option value="customers" <?= $filter == 'customers' ? 'selected' : '' ?>>
                                Kunden
                            </option>
                        </select>
                    </div>
                    <a href="/new_user.php" class="highlighted-button">Kunde hinzufügen</a>

                </div>
            </div>
        </form>
    </div>
    <div class="result-container" style="grid-column: 2/13">
        <?= print_r($users) ?>
    </div>
</main>
<?php include_once "templates/footer.php" ?>
</body>
</html>