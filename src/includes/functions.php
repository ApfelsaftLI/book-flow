<?php
function getProfilePicture(array $user): string {
    return 'https://api.dicebear.com/8.x/initials/svg?seed=' . getFirstLetter($user["vorname"]) . getFirstLetter($user["name"]) . $user["vorname"] . $user["name"];
}

function getFirstLetter(string $str) {
    return substr($str, 0, 1);
}

function shortenShortTitles(array $dbResults) {
    $dbResults['kurztitle'] = substr($dbResults['kurztitle'], 0, 20);;
    return $dbResults;
}