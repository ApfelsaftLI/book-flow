<?php
function getProfilePicture(array $user): string {
    return 'https://api.dicebear.com/8.x/initials/svg?seed=' . getFirstLetter($user["vorname"]) . getFirstLetter($user["name"]) . $user["vorname"] . $user["name"];
}

function getFirstLetter(string $str) {
    return substr($str, 0, 1);
}

function shortenShortTitles(array $dbResults) {
    $shortShortTitles = $dbResults['kurztitle'];
    foreach ($shortShortTitles as $i => $title) {
        $shortTitles[$i] = substr($title, 0, 20);
    }
    $dbResults['kurztitle'] = $shortShortTitles;
    return $dbResults;
}