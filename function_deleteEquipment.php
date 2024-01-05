<?php
    require "dbconnect.php";

    $equipID = $_GET["equipID"];

    //delete equipments from database
    $deleteSQL = "DELETE FROM equipment WHERE equipID = '$equipID'";
    if (mysqli_query($connect, $deleteSQL)) {
        echo "<script>alert('Equipment deleted successfully!'); history.back();</script>";
    } else {
        echo "<script>alert('Deleting equipment failed!: " . mysqli_error($connect) . " '); history.back();</script>";
    }

?>