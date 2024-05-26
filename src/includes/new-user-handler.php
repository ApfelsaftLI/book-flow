<?php
echo print_r($_POST);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!validateName($_POST)) return;
    $name = explode(" ", trim($_POST['name']))[-1];
    $firstName = explode(" ", trim($_POST['name']))[0];

    if (!validateEmail($_POST)) return;
    $email = trim($_POST['email']);

    $mailcontact = $_POST['mailcontact'] ?? 0;
    $mailcontact = in_array($mailcontact, [0, 1]) ? $mailcontact : 0;

    $birthdate = $_POST['birthdate'] ?? null;
    if (!validateEmail())



    $gender = $_POST['gender'] ?? null;

}

function validateName(array $userArray): bool {
    if (!isset($userArray['name'])) {
        fail("Es wurde kein Name angegeben.");
        return false;
    }

    $name = $userArray['name'];

    if (count(explode(" ", $name)) < 2) {
        fail('"' . $name . '" ist kein ganzer Name.');
        return false;
    }

    return true;
}

function validateEmail(array $userArray): bool {
    if (isset($userArray['email'])) {
        $email = trim($userArray['email']);
        if (strlen($email) > 50) {
            fail("Die Emailadresse ist zu lange.");
            return false;
        }
        if ($email == "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            fail("Die Emailadresse ist ungültig!");
            return false;
        } else {
            return true;
        }
    } else {
        fail("Die Emailadresse ist ungültig!");
        return false;
    }
}

function validateDate($date) {
    $dateArray = explode('-', $date);
    if (count($dateArray) == 3) {
        return checkdate($dateArray[1], $dateArray[2], $dateArray[0]);
    }
    return false;
}

function fail(string $message) {
    echo "<div class='error'><p><b>Nutzer konnte nicht erstellt werden:</b> " . $message . "</p></div>";
}