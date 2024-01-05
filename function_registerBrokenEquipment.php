<?php
    require "dbconnect.php";

    if (isset($_POST["submit"])) {
        $equipID = $_POST["equipID"];
        $brokenDate = $_POST["brokenDate"];
        $brokenDetails = $_POST["brokenDetails"];

        $brokenSQL = "INSERT INTO brokenequipment (equipID, brokenDate, brokenDetail)
                    VALUES ('$equipID', '$brokenDate', '$brokenDetails')";
        
        if (mysqli_query($connect, $brokenSQL)) {
            $deleteSQL = "DELETE FROM equipment WHERE equipID = '$equipID'";
            if (mysqli_query($connect, $deleteSQL)) {
                echo "<script>alert('Equipment updated successfully and removed from equipment table!'); window.location.href = 'admin_equipments.php';</script>";
            } else {
                echo "<script>alert('Equipment removal failed! " . mysqli_error($connect) . "'); history.back();</script>";
            }
        } else {
            echo "<script>alert('Equipment update failed! " . mysqli_error($connect) . "'); history.back();</script>";
        }
    }
?>