<?php
if (!empty($_POST['logout'])) {
    unset($_SESSION['user']);
    return;
}

if (!isset($_POST['register'])){
if (!checkAttemptedLogin()) return;
if (!checkEmail()) return;
if (!checkPassword(cleanString($_POST['email']))) return;
} else {
    //handling registering new users
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $errors = [];

        // Validate and sanitize inputs
        $name = isset($_POST["name"]) ? htmlspecialchars(trim($_POST["name"])) : '';
        $username = isset($_POST["username"]) ? htmlspecialchars(trim($_POST["username"])) : '';
        $email = isset($_POST["email"]) ? htmlspecialchars(trim($_POST["email"])) : '';
        $password = isset($_POST["password"]) ? intval(trim($_POST["password"])) : 0;

            if ($newPassword !== $newPasswordRepeat) {
        fail("Die Passwörter sind nicht gleich!");
    }


        $maxNameLength = 50;
        $maxUsernameLength = 50;
        $maxEmailLength = 50;
        $maxPasswordLength = 5;

        if (empty($name)) {
            $errors[] = "Name is required.";
        } elseif (strlen($name) > $maxNameLength) {
            $errors[] = "Name cannot exceed $maxNameLength characters.";
        }

        if (empty($username)) {
            $errors[] = "Username is required.";
        } elseif (strlen($username) > $maxUsernameLength) {
            $errors[] = "Usernmae cannot exceed $maxUsernameLength characters.";
        }

        if (empty($email)) {
            $errors[] = "Email is required.";
        } elseif (strlen($email) > $maxEmailLength) {
            $errors[] = "Email cannot exceed $maxEmailLength characters.";
        }

        if (empty($password)) {
            $errors[] = "Password is required.";
        } elseif (strlen($password) > $maxPasswordLength) {
            $errors[] = "Password cannot exceed $maxPasswordLength characters.";
        }

}}

//check if the email is correct
function checkEmail(): bool {
    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);
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

//check if password is correct
function checkPassword($email): bool {
    if (isset($_POST['password'])) {
        $password = cleanString($_POST['password']);
        if (strlen($password) > 50) {
            fail("Das Passwort ist zu lange.");
            return false;
        }
        if ($password == "") {
            fail("Das Passwort ist leer!");
            return false;
        } else {
            include_once "db.php";
            $passwordHash = getPasswordHash($email);
            if (password_verify($password, $passwordHash)) {

                $_SESSION['user'] = getUser($email);

                return true;
        
            }
            fail("Es ist ein Fehler beim Login vorgefallen");
            return false;
        }
    } else {
        fail("Das Passwort ist ungültig!");
        return false;
    }
}

//function for outputting errors
function fail(string $message) {
    echo "<div class='error'><p><b>Login failed:</b> " . $message . "</p></div>";
}

function checkAttemptedLogin(): bool {
    return (isset($_POST['email']) && isset($_POST['password']) && !(trim($_POST['email'])) == "" && !(trim($_POST['password'])) == "");
}

function cleanString(string $input): string {
    return htmlspecialchars(trim($input));
}
