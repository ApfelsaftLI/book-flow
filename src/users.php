<?php
session_start();
include_once "includes/db.php";


$search = $_GET['search'] ?? '';
$search = trim($search);

$filter = $_GET['filter'] ?? "users";

$currentPage = $_GET['page'] ?? 1;
$users = $filter == "users" ? getUserArray($search, 1) : getCustomerArray($search, 1);

$queryParameters = "?search=" . $search . "&filter=" . $filter;
$pagesNeeded = $filter == "users" ? getUserPages($search) : getCustomerPages($search);


if (count($users) == 0) {
    echo '<div class="error"><h3>Leider konnte kein Resultat gefunden werden, versuchen Sie es doch mit einer neuen Suche.</h3></div>';
}
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
                           value="<?= $search ?>">
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
    <div class="result-container">
        <?php if ($filter == "users"): ?>
            <?php foreach ($users as $user): ?>
                <div class="userbox">
                    <div class='profile-picture'
                         style='background-image: url("<?= getProfilePicture($user) ?>")'></div>
                    <div class="user-informations">Tim Landolt</div>
                    <div class="user-admin-status">No</div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>

        <?php endif; ?>
    </div>
    <!-- Pagination -->
    <div class="pagination">
        <a href="<?= $queryParameters . "&page=" . max(1, $currentPage - 1) ?>"
           class="pagination-btn <?= $currentPage == 1 ? 'disabled' : '' ?>">◄</a>
        <?php
        for ($i = max(1, $currentPage - 2); $i <= min($pagesNeeded, $currentPage + 2); $i++):
            ?>
            <a href="<?= $queryParameters . "&page=" . $i ?>" <?= $i === $currentPage ? 'class="active"' : ''; ?>><?= $i; ?></a>
        <?php endfor; ?>
        <a href="<?= $queryParameters . "&page=" . min($pagesNeeded, $currentPage + 1) ?>"
           class="pagination-btn <?= $currentPage == $pagesNeeded ? 'disabled' : '' ?>">►</a>
    </div>
</main>
<?php include_once "templates/footer.php" ?>
</body>
</html>
