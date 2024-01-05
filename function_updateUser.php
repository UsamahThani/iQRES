<?php
    require "dbconnect.php";
    include "function_ImgurAPI.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userID = $_POST["userID"];
        $userName = $_POST["userName"];
        $userPass = $_POST["userPass"];
        $userImg = $_FILES["userImg"]["name"];
        $userType = $_POST["userType"];
        $linkUser = strtolower($_POST["userType"]);
        $userCap = ucfirst($linkUser);

        $setClause = "";
        if (!empty($userName)) {
            $setClause .= "userName = '$userName', ";
        }
        if (!empty($userPass)) {
            $hashedPass = password_hash($userPass, PASSWORD_DEFAULT);
            $setClause .= "userPass = '$hashedPass', ";
        }
        if (!empty($userImg)) {
            $imgLink = imgurLink($_FILES["userImg"]);
            $setClause .= "userImg = '$imgLink', ";
        }
        if (!empty($userType)) {
            $setClause .= "userType = '$userType', ";
        }

        //remove the comma from clause
        $setClause = rtrim($setClause,", ");

        //check if the clause empty
        if (!empty($setClause)) {
            //update based on the set clause
            $updateSQL = "UPDATE user SET $setClause WHERE userID = '$userID'";
            $updateResult = mysqli_query($connect, $updateSQL);

            if ($updateResult) {
                echo "<script>alert('".$userCap." updated successfully!'); window.location.href = 'admin_".$linkUser.".php';</script>";
            } else {
                "<script>alert('Error updating ".$linkUser." details: ". mysqli_error($connect) ."'); history.back();</script>";
            }
        } else {
            "<script>alert('No fields to update'); window.location.href = 'admin_".$linkUser."_edit.php';</script>";
        }
    } else {
        echo "Invalid request method.";
    }

?>