<header>
    <a href="/">
        <img src="../assets/images/BookFlow_Logo.svg" alt="BookFlow Logo">
    </a>
    <nav>
        <ul>
            <li class="text-small-semi"><a href="/">Home</a></li>
            <li class="text-small-semi"><a href="/books.php">Bücherkatalog</a></li>
            <?php if ($_SESSION["user"]["admin"] == "true") echo "<li class='text-small-semi'><a href='/users.php'>Nutzer</a></li>" ?>
            <?php if (!isset($_SESSION["user"])) {
                echo "<li class='text-small-semi'><a href='/login.php'>Login</a></li>";
                echo "<a href='/login.php' class='profile-picture'></a>";
            } else {
                include_once "includes/functions.php";
                echo "<a href='/login.php' class='profile-picture' style='background-image: url(\"" . getProfilePicture($_SESSION["user"]) . "\")'></a>";
            }
            ?>
        </ul>
    </nav>
</header>