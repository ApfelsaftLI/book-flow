<?php
$username = 'root';
$password = 'root';
$server = 'book-flow-mysql';

try {
    $connection = new PDO("mysql:host=$server;port=3306;dbname=book_DB", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo 'Juhuuu Verbindig stoht!!';
} catch (PDOException $e) {
    echo "Ohje :( ->  ".$e->getMessage();
}