<?php

// check if entry is valid
$valid = true;
// TODO: check formatting of inputs
$input_names = array('username', 'email', 'password');
foreach ($input_names as $input_name) {
    if (empty($_POST[$input_name])) {
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
    $password =
        password_hash($mysqli->real_escape_string($_POST['password']),
                PASSWORD_BCRYPT);

    // add new user to database
    $mysqli->query(
            "INSERT INTO users (username, email, password)
            VALUES ('$username', '$email', '$password')"
            );

    // close database connection
    $mysqli->close();

    // redirect to sign in page
    header('location:sign-in.html');
} else {
    echo '<p>Invalid entry. Account not created.</p>';
    echo '<p><a href="new-account.html">Back</a></p>';
}

exit(0);

