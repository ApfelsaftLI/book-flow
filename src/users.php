<?php
session_start();
if (!isset($_SESSION['user']) || !$_SESSION['user']['admin']) header("Location: ../");

include_once "./includes/user-handler.php";

include_once "includes/db.php";
include_once "includes/functions.php";

if (isset($_POST['admin-status-id']) && isset($_POST['admin-status'])) {
    $successfulUpdate = updateAdminStatus($_POST['admin-status-id'], $_POST['admin-status']);

    if ($successfulUpdate) {
        echo "<div class='success'><b>Der admin Status vom user #{$_POST['admin-status-id']} konte erfolgreich gesetzt werden.</b></div>";
    } else {
        echo "<div class='error'><b>Der admin Status vom Nutzer #{$_POST['admin-status-id']} konte leider nicht gesetzt werden.</b></div>";
    }
}

$search = $_GET['search'] ?? '';
$search = trim($search);

$filter = $_GET['filter'] ?? "users";

$currentPage = $_GET['page'] ?? 1;
$users = $filter == "users" ? getUserArray($search, $currentPage) : getCustomerArray($search, $currentPage);

$queryParameters = "?search=" . $search . "&filter=" . $filter;
$pagesNeeded = $filter == "users" ? getUserPages($search) : getCustomerPages($search);

$fullQuery = $queryParameters . "&page=" . $currentPage;

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
                    <?php if ($filter == 'customers'): ?>
                        <a href="./new_user.php" class="highlighted-button">Kunde hinzufügen</a>
                    <?php endif; ?>

                </div>
            </div>
        </form>
    </div>
    <div class="result-container">
        <!-- Nutzer -->
        <?php if ($filter == "users"): ?>
            <?php foreach ($users as $user): ?>
                <div class="userbox">
                    <div class='profile-picture'
                         style='background-image: url("<?= getProfilePicture($user) ?>")'></div>
                    <div class="user-informations">
                        <div><p class="user-username text-medium-semi"><?= $user['benutzername'] ?></p>
                            <p class="user-fullname text-medium-normal"><?= "(" . $user['vorname'] . " " . $user['name'] . ")" ?>
                            </p></div>
                        <div><p class="user-id text-small-normal">#<?= $user['ID'] ?></p>
                            <a class="user-email text-small-semi"
                               href="mailto:<?= strtolower($user['email']) ?>"><?= strtolower($user['email']) ?></a>
                        </div>
                    </div>
                    <div class="user-admin-status">
                        <form action="<?= './users.php' . $fullQuery ?>" method="post">
                            <input type="hidden" name="admin-status-id" value="<?= $user['ID'] ?>">
                            <select name="admin-status"
                                    id="user-admin-status-<?= $user['ID'] ?>"
                                    onchange="this.form.submit()">
                                <option value="1" <?= $user['admin'] == 1 ? "selected" : "" ?>>Admin</option>
                                <option value="0" <?= $user['admin'] != 1 ? "selected" : "" ?>>Nutzer</option>
                            </select></form>
                    </div>
                </div>

            <?php endforeach; ?>
            <!-- Kunden -->
        <?php else: ?>
            <?php foreach ($users as $customer): ?>
                <div class="customerbox">
                    <div class='profile-picture'
                         style='background-image: url("<?= getProfilePicture($customer) ?>")'></div>
                    <div class="customer-informations">
                        <div>
                            <p class="customer-fullname text-medium-normal"><?= $customer['vorname'] . " " . $customer['name'] ?></p>
                            <?php if (!($customer['geschlecht'] != "M" && $customer['geschlecht'] != "F")): ?>
                                <img src="./assets/images/<?= $customer['geschlecht'] == "M" ? "male.svg" : "female.svg" ?>"
                                     draggable="false">
                            <?php endif ?>

                            <?php if (validateDate($customer['geburtstag'])): ?>
                                <p class="customer-birthdate text-small-normal"><?= reformateDate($customer['geburtstag']) ?></p>
                            <?php endif ?>
                        </div>
                        <div>
                            <p class="customer-id text-small-normal">#<?= $customer['kid'] ?></p>
                            <p class="customer-join-date text-small-normal"><?= reformateDate($customer['kunde_seit']) ?></p>
                            <img src="./assets/images/<?= $customer['kontaktpermail'] == "1" ? "email_yes.svg" : "email_no.svg" ?>"
                                 draggable="false">
                            <a class="user-email text-small-semi"
                               href="mailto:<?= strtolower($customer['email']) ?>"><?= strtolower($customer['email']) ?></a>
                        </div>
                    </div>
                    <a class="customer-edit-button" href="./edit_customer.php?id=<?= $customer['kid'] ?>"></a>
                </div>

            <?php endforeach; ?>

        <?php endif; ?>
    </div>
    <!-- Pagination -->
    <div class="pagination">
        <a href="<?= $queryParameters . "&page=" . max(1, $currentPage - 1) ?>"
           class="pagination-btn <?= $currentPage == 1 ? 'disabled' : '' ?>">◄</a>
        <?php
        for ($i = max(1, $currentPage - 2); $i <= min($pagesNeeded, $currentPage + 2); $i++):
            ?>
            <a href="<?= $queryParameters . "&page=" . $i ?>" <?= $i == $currentPage ? 'class="active"' : ''; ?>><?= $i; ?></a>
        <?php endfor; ?>
        <a href="<?= $queryParameters . "&page=" . min($pagesNeeded, $currentPage + 1) ?>"
           class="pagination-btn <?= $currentPage == $pagesNeeded ? 'disabled' : '' ?>">►</a>
    </div>
</main>
<?php include_once "templates/footer.php" ?>
</body>
</html>
