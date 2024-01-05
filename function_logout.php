<?php
    session_start(); // Start or resume the current session
    require "dbconnect.php";

    // Destroy all session data
    session_destroy();

    // Prevent caching of the current page
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

    // Redirect to the index.php or any other page you want
    header("Location: index.php");

    //terminate database
    mysqli_close($connect);
    exit;
?>