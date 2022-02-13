<?php

// check if entry is valid
$valid = true;
// TODO: check formatting of inputs
$input_names = array('username', 'password');
foreach ($input_names as $input_name) {
    if (empty($_POST[$input_name])) {
        $valid = false;
        break;
    }
}

if ($valid) {
    // connect to database
    require_once 'config/mysql-connection.php';
    // get entered username
    $entered_username = $mysqli->real_escape_string($_POST['username']);
    // get user data from database based on entered username
    // TODO: only get necessary info
    $result = $mysqli->query(
            "SELECT *
            FROM users
            WHERE username = '$entered_username'
            OR email = '$entered_username'
            LIMIT 1"
            );
    // check if user exists based on number of resulting rows
    if ($result->num_rows == 1) {
        // convert result to array
        $user = $result->fetch_assoc();
        // check if hash of entered password matches stored hash
        if (password_verify($mysqli->real_escape_string($_POST['password']),
                    $user['password'])) {
            // start session if not already started
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            // store user ID in session variable
            $_SESSION['id'] = $user['id'];
            // close database connection
            $mysqli->close();
            // TODO: redirect to signed-in page
            echo '<p>You have successfully signed in.</p>';
        }
    }
    echo '<p>Username or password is incorrect.</p>';
} else {
    echo '<p>Invalid entry. Could not sign in.</p>';
}
echo '<p><a href="sign-in.html">Back</a></p>';

exit(0);

