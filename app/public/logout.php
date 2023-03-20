<?php 
    // resume session
    session_start();

    // clear session object
    session_unset();
    session_destroy();

    // prepare new session and notify user of logout
    session_start();
    $_SESSION['message'] = "You are logged out";

    // redirect user to login page

    header("location: login.php");
?>