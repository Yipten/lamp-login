<?php

// check if entry is valid
$valid = true;
foreach ($_POST as $input) {
    if (empty($input)) {
        $valid = false;
        break;
    }
}

// only proceed with DB operations if entry is valid
if ($valid) {
    // connect to database
    require_once 'config/mysql-connection.php';

    // get user input & escape special characters
    $username = $mysqli->real_escape_string($_POST['username']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['password']);

    // add new user to database
    $mysqli->query(
            "INSERT INTO users (username, email, password)
            VALUES ('$username', '$email', '$password')"
            );

    // close database connection
    $mysqli->close();

    // redirect to sign in page
    header('location:sign-in.html');
    exit(0);
} else {
    echo '<p>Invalid entry. Account not created.</p>';
    echo '<p><a href="new-account.html">Back</a></p>';
}

