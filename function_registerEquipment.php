<?php
    require "dbconnect.php";
    include "function_ImgurAPI.php";

    if (isset($_POST["submit"])) {
        $equipID = $_POST["equipID"];
        $equipName = $_POST["equipName"];
        $equipRegisterDate = $_POST["equipRegisterDate"];
        $equipPurchaseDate = $_POST["equipPurchaseDate"];
        $equipCategory = $_POST["equipCategory"];
        $imgurLink = ImageFileToImgur($equipID);

        $equipSQL = "INSERT INTO equipment (equipID, equipName, equipCategory, equipRegisterDate, equipPurchaseDate, equipQRImg)
                    VALUES ('$equipID', '$equipName',  '$equipCategory', '$equipRegisterDate', '$equipPurchaseDate', '$imgurLink')";
        
        if (mysqli_query($connect, $equipSQL)) {
            echo "<script>alert('Equipment registered successfully.'); window.location.href = 'admin_equip_list.php?equipCategory=".$equipCategory."';</script>";
        } else {
            echo "<script>alert('Equipment registration failed! " . mysqli_error($connect) . "'); history.back();</script>";
        }
    }
?>