<?php
include_once '../../../php/landfill.php';

session_start();
// replace with sec_session_start.
 
if (isset($_POST['username'], $_POST['password'])) {
    $email = $_POST['username'];
    $password = $_POST['password']; // update with hashed password.
 
    if (login($username, $password, $mysqli) == true) {
        // Login success 
        header('Location: index.php');
    } else {
        // Login failed 
        header('Location: failedstakeout.htm');
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}

?>