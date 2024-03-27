<?php
$isLoggedIn = array_key_exists("user", $_SESSION);
$isAdmin = $isLoggedIn && $_SESSION["user"]["admin"] == "true";
?>

<footer>
    <p class="text-small-semi">&copy; BookFlow <?php echo date("Y") ?></p>
    <nav>
        <ul>
            <li class="text-small-semi"><a href="/">Home</a></li>
            <li class="text-small-semi"><a href="/books.php">Bücherkatalog</a></li>
            <?php
            if ($isLoggedIn) {
                if ($isAdmin) {
                    echo "<li class='text-small-semi' ><a href = '/users.php' > Nutzer</a ></li>" . PHP_EOL;
                }
                echo "<li class='text-small-semi'><a href='/profile.php'>Profil</a></li>" . PHP_EOL;
            } else {

                echo "<li class='text-small-semi'><a href='/login.php'>Login</a></li>" . PHP_EOL;
            }
            ?>
        </ul>
    </nav>
</footer>
