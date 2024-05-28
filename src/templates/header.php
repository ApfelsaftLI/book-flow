<?php
include_once "includes/functions.php";
$isLoggedIn = array_key_exists("user", $_SESSION);
$isAdmin = $isLoggedIn && $_SESSION["user"]["admin"] == "true";
?>

<header>
    <a href="/">
        <img src="../assets/images/BookFlow_Logo.svg" alt="BookFlow Logo">
    </a>
    <nav>
        <ul>
            <li class="text-small-semi"><a href="/">Home</a></li>
            <li class="text-small-semi"><a href="/books.php">Bücherkatalog</a></li>
            <?php
            if (!$isLoggedIn) {
                echo "<li class='text-small-semi'><a href='/login.php'>Login</a></li>" . PHP_EOL;
            } else {
                if ($isAdmin) {
                    echo "<li class='text-small-semi' ><a href = '/users.php' > Nutzer</a ></li>" . PHP_EOL;
                }
                echo "<li class='text-small-semi' ><a href = '/change_password.php' > Passwort ändern</a ></li>" . PHP_EOL;
                echo "<li class='text-small-semi'><form action='/' method='post'><button type='submit' name='logout' value='true'>Logout</button></form></li>" . PHP_EOL;
            }
            ?>
        </ul>

        <?php
        if ($isLoggedIn) {
            echo "<a href='/profile.php' class='profile-picture'
                 style='background-image: url(\"" . getProfilePicture($_SESSION["user"]) . "\")'></a>" . PHP_EOL;
            // If the IDE shows an error IGNORE IT!!
        } else {

            echo "<a href='/login.php' class='profile-picture'></a>" . PHP_EOL;
        }
        ?>
    </nav>
</header>