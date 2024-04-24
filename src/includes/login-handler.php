<?php
if (!checkAttemptedLogin()) return;
if (!checkEmail()) return;
if (!checkPassword(cleanString($_POST['email']))) return;


function checkEmail(): bool {
    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);
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

function checkPassword($email): bool {
    if (isset($_POST['password'])) {
        $password = cleanString($_POST['password']);
        if ($password == "") {
            fail("Das Passwort ist ungültig!");
            return false;
        } else {
            include_once "db.php";
            $passwordHash = getPasswordHash($email);
            if (password_verify($password, $passwordHash)) {

                $_SESSION['user'] = getUser($email);

                return true;
            }
        }
    } else {
        fail("Das Passwort ist ungültig!");
        return false;
    }
}


function fail(string $message) {
    echo "<div class='error'><p><b>Login failed:</b> " . $message . "</p></div>";
}

function checkAttemptedLogin(): bool {
    return (isset($_POST['email']) && isset($_POST['password']) && !(trim($_POST['email'])) == "" && !(trim($_POST['password'])) == "");
}

function cleanString(string $input): string {
    return htmlspecialchars(trim($input));
}