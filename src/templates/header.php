<header>
    <a href="/">
        <img src="../assets/images/BookFlow_Logo.svg" alt="BookFlow Logo">
    </a>
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/books">Bücherkatalog</a></li>
            <?php if ($_SESSION["admin"]) echo "<li><a href='/users'>Nutzer</a></li>" ?>
            <?php if (!$_SESSION["loggedIn"]) echo "<li><a href='/login'>Login</a></li>" ?>
        </ul>
    </nav>
</header>