<?php
    require "dbconnect.php";
    include "function_ImgurAPI.php";

    if (!empty(imgurLink($_FILES["userImg"]))){
        $userID = $_POST["userID"];
        $userName = $_POST["userName"];
        $userPass = $_POST["userPass"];
        $imgLink = imgurLink($_FILES["userImg"]);
        $userType = $_POST["userType"];
        $linkUser = strtolower($_POST["userType"]);
        $userCap = ucfirst($linkUser);

        //hashed the userPass
        $hashedPassword = password_hash($userPass, PASSWORD_DEFAULT);
        $query = "INSERT INTO user (userID, userName, userPass, userImg, userType) 
                VALUES ('$userID', '$userName', '$hashedPassword', '$imgLink', '$userType')";

        if (mysqli_query($connect, $query)) {
            echo "<script>alert('".$userCap." registered successfully! Welcome " . $userName . "!'); window.location.href = 'admin_".$linkUser.".php';</script>";
        } else {
            echo "<script>alert('".$userCap." registration failed! " . mysqli_error($connect) . "'); history.back();</script>";
        }
    }


?>