<?php
include 'db.php';
function listFullUserNames()
{
    if (!$_SESSION["dbConnection"]) return;
    global $connection;
    $sql = "SELECT vorname, name from benutzer";
    foreach ($connection->query($sql) as $row) {
        echo $row['vorname'] . " " . $row['name'] . "<br/>";
    }
}