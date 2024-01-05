<?php
    require "dbconnect.php";

    if (isset($_POST["submit"])) {
        $cateID = $_POST["cateID"];
        $cateName = $_POST["cateName"];
        $cateRegisterBy = $_POST["cateRegisterBy"];

        // Check if cateID or cateName already exist
        $checkQuery = "SELECT * FROM categoryequipment WHERE cateID = '$cateID' OR cateName = '$cateName'";
        $result = mysqli_query($connect, $checkQuery);

        if (mysqli_num_rows($result) > 0) {
            // Category already exists
            echo "<script>alert('Category with ID or Name already exists!'); history.back();</script>";
        } else {
            // Insert new category
            $query = "INSERT INTO categoryequipment (cateID, cateName, cateRegisterBy)
                    VALUES ('$cateID', '$cateName', '$cateRegisterBy')";
            
            if (mysqli_query($connect, $query)) {
                echo "<script>alert('".$cateName." has been registered successfully.'); window.location.href = 'admin_equipments.php';</script>";
            } else {
                echo "<script>alert('".$cateName." registration failed! " . mysqli_error($connect) . "'); history.back();</script>";
            }
        }
    }
?>
