<?php
session_start();
include_once "includes/db.php";
include_once "includes/functions.php";
$sucess = deleteBook($_GET['book_id']);
header("Location: books.php");