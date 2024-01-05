<?php
    require "dbconnect.php";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $equipID= $_POST["equipID"];
        $equipName = $_POST["equipName"];
        $equipRegisterDate = $_POST["equipRegisterDate"];
        $equipPurchaseDate = $_POST["equipPurchaseDate"];
        $equipCondition = $_POST["equipCondition"];
        $equipCategory = $_POST["equipCategory"];

        if ($equipCondition == "Broken") {
            header("Location: admin_equip_broken.php?equipID=$equipID");
            exit();
        } else {

            //check if the form is empty
            $setClause = "";
            if (!empty($equipName)) {
                $setClause .= "equipName = '$equipName', ";
            }
            if (!empty($equipRegisterDate)) {
                $setClause .= "equipRegisterDate = '$equipRegisterDate', ";
            }
            if (!empty($equipPurchaseDate)) {
                $setClause .= "equipPurchaseDate = '$equipPurchaseDate', ";
            }
            if (!empty($equipCondition)) {
                $setClause .= "equipCondition = '$equipCondition', ";
            }

            //remove the comma from the clause
            $setClause = rtrim($setClause,", ");

            //check if the clause empty
            if (!empty($setClause)) {
                $updateSQL = "UPDATE equipment SET $setClause WHERE equipID = '$equipID'";
                $updateResult = mysqli_query($connect, $updateSQL);

                if($updateResult) {
                    echo "<script>alert('".$equipID." updated successfully!'); window.location.href = 'admin_equip_list.php?equipCategory=".$equipCategory."';</script>";
                } else {
                    echo "<script>alert('Error updating ".$equipID." details: ". mysqli_error($connect) ."'); history.back();</script>";
                }
            } else {
                echo "<script>alert('No fields to update'); window.location.href = 'admin_".$linkUser."_edit.php';</script>";
            }
        }
    } else {
        echo "Invalid request method.";
    }
?>