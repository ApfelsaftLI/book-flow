<?php
function getProfilePicture(array $user): string
{
    return 'https://api.dicebear.com/8.x/initials/svg?seed=' . getFirstLetter($user["firstName"]) . getFirstLetter($user["name"]) . $user["firstName"] . $user["name"];
}

function getFirstLetter(string $str)
{
    return substr($str, 0, 1);
}

