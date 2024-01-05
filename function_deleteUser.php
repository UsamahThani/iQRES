<?php
    session_start();
    require "dbconnect.php";

    $userID = $_GET["userID"];
    $userType = $_GET["userType"];

    // delete user from database
    $deleteSQL = "DELETE FROM user WHERE userID = '$userID'";
    if (mysqli_query($connect, $deleteSQL)) {
        echo "<script>alert('User deleted successfully!'); history.back();</script>";
    } else {
        echo "<script>alert('Deleting user failed!: " . mysqli_error($connect) . " '); history.back();</script>";
    }
?>