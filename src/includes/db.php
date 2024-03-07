<?php
$username = 'root';
$password = 'root';
$server = 'book-flow-mysql';
$connection = null;

try {
    $connection = new PDO("mysql:host=$server;port=3306;dbname=book_DB", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Die Verbindung zur Datenbank konnte nicht hergestellt werden: " . $e->getMessage();
}