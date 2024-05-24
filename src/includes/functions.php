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

function shortenShortTitlesShorter(array $dbResults) {
    $dbResults['kurztitle'] = substr($dbResults['kurztitle'], 0, 12);;
    return $dbResults;
}

function shortenAutor(array $dbResults) {
    $dbResults['autor'] = substr($dbResults['autor'], 0, 20);;
    return $dbResults;
}

function checkFileExtension($ext) {
    if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
        $pass = 1;
    } else {
        $pass = 0;
    }
    return $pass;
}