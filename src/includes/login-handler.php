<?php
echo print_r($_POST);
if (isset($_POST['email'])) {
    $email = trim($_POST['email']);
    if ($email == "" || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        fail("Die Emailadresse ist ungültig!");
    }
} else {
    fail("Die Emailadresse ist ungültig!");
}


function fail(string $message) {
    echo "<div class='error'><p><b>Login failed:</b> " . $message . "</p></div>";
}