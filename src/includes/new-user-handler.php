<?php
include_once "functions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete']) && isset($_POST['id'])) {
        deleteCustomer($_POST['id']);
    } else {

        $newUser = [];

        if (!validateName($_POST)) return;
        $nameArray = explode(" ", trim($_POST['name']));
        $newUser['name'] = ucfirst(end($nameArray));
        $newUser['first-name'] = ucfirst($nameArray[0]);

        if (!validateEmail($_POST)) return;
        $newUser['email'] = trim($_POST['email']);

        $mailcontact = $_POST['mailcontact'] ?? 0;
        $mailcontact = in_array($mailcontact, [0, 1]) ? $mailcontact : 0;
        $newUser['mailcontact'] = $mailcontact;

        if (validateDate($_POST['birthdate'])) {
            $newUser['birthdate'] = $_POST['birthdate'];
        } else {

            $newUser['birthdate'] = null;
        }

        $newUser['gender'] = $_POST['gender'] != "N" ? $_POST['gender'] : null;

        $newUser['customer-since'] = date("Y-m-d");

        include_once "db.php";

        if (isset($_POST['id'])) {
            $newUser['id'] = $_POST['id'];
            if (!editCustomer($newUser)) fail("<br>Der Nutzer konnte nicht in die Datenbank übertragen werden.");
        } else {
            if (!addCustomer($newUser)) fail("<br>Der Nutzer konnte nicht in die Datenbank übertragen werden.");
        }
    }
}

function validateName(array $userArray): bool
{
    if (!isset($userArray['name'])) {
        fail("Es wurde kein Name angegeben.");
        return false;
    }

    $name = $userArray['name'];

    if (count(explode(" ", $name)) < 2) {
        fail('"' . $name . '" ist kein ganzer Name.');
        return false;
    }

    if (strlen($name) > 50) {
        fail('Der angegebene Name ist zu kurz.');
        return false;
    }

    return true;
}

function validateEmail(array $userArray): bool
{
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

function fail(string $message)
{
    echo "<div class='error'><p><b>Nutzer konnte nicht erstellt werden:</b> " . $message . "</p></div>";
}