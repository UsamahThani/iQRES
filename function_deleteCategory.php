<?php
    require "dbconnect.php";

    $cateID = $_GET["cateID"];

    // delete user from database
    $deleteSQL = "DELETE FROM categoryequipment WHERE cateID = '$cateID'";
    if (mysqli_query($connect, $deleteSQL)) {
        echo "<script>alert('Category deleted successfully!'); window.location.href='admin_equipments.php';</script>";
    } else {
        echo "<script>alert('Deleting category failed!: " . mysqli_error($connect) . " '); history.back();</script>";
    }
?>