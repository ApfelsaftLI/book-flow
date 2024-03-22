<?php
function listFullUserNames()
{
    if (!$_SESSION["dbConnection"]) return;
    require_once 'db.php';
    global $connection;
    $sql = "SELECT vorname, name from benutzer";
    foreach ($connection->query($sql) as $row) {
        echo $row['vorname'] . " " . $row['name'] . "<br/>";
    }
}

function getProfilePicture(array $user): string
{
    return 'https://api.dicebear.com/8.x/initials/svg?seed=' . getFirstLetter($user["firstName"]) . getFirstLetter($user["name"]) . $user["firstName"] . $user["name"];
}

function getFirstLetter(string $str)
{
    return substr($str, 0, 1);
}