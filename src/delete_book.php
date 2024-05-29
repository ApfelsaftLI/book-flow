<?php
session_start();
include_once "includes/db.php";
include_once "includes/functions.php";
$isLoggedIn = array_key_exists("user", $_SESSION);
$isAdmin = $isLoggedIn && $_SESSION["user"]["admin"] == "true";

if (!$isAdmin) {
    header("Location: index.php");
    exit;
}

deleteBook($_GET['book_id']);
header("Location: books.php");