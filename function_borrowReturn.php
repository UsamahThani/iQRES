<?php
    session_start();
    include ("function_checkSession.php");
    include ("function_borrowID.php");
    require "dbconnect.php";
    checkLogin($_SESSION["userId"]);

    $studentID = $_SESSION["userId"];
    $equipID = $_POST["equipID"];
    $borrowStatus = false;
    $returnStatus = true;

    

    if ($_POST["formType"] == "borrowForm"){

        $borrowID = generateBorrowID();
        $equipCategory = $_POST["equipCategory"];

        // insert borrow data into database
        $borrowSQL = "INSERT INTO BORROW (borrowID, studentID, equipID, equipCategory, borrowDateTime)
        VALUES (?, ?, ?, ?, NOW())";

        $stmt = mysqli_prepare($connect, $borrowSQL);
        mysqli_stmt_bind_param($stmt,"isss", $borrowID, $studentID, $equipID, $equipCategory);

        if (mysqli_stmt_execute($stmt)) {
            // update the equipIsAvailable to false
            $updateStatusSQL = "UPDATE equipment SET equipIsAvailable = ? WHERE equipID = ?";

            $updateStmt = mysqli_prepare($connect, $updateStatusSQL);
            mysqli_stmt_bind_param($updateStmt,"is", $borrowStatus, $equipID);

            if (mysqli_stmt_execute($updateStmt)) {
                echo "<script>alert('Borrow recorded successfully.'); window.location.href = 'user_equipments.php';</script>";
            } else {
                echo "<script>alert('Error updating equipment status: " . mysqli_error($connect) . "')</script>";
            }

            
        } else {
            echo "<script>alert('Error: " . mysqli_error($connect) . "')</script>";
        }

        
    } elseif ($_POST["formType"] == "returnForm"){
        $borrowID = findBorrowID($equipID);
        //todo: calculate borrowPeriod
        $timeSQL = "SELECT borrowDateTime FROM borrow WHERE borrowID = '$borrowID'";
        $timeResult = mysqli_query($connect, $timeSQL);
        
        if ($timeResult) {
            $row = mysqli_fetch_array($timeResult);
            $borrowDateTime = $row["borrowDateTime"];

            date_default_timezone_set('Asia/Kuala_Lumpur');
            $returnDateTime = date("Y-m-d H:i:s");
            $period = round(strtotime($returnDateTime) - strtotime($borrowDateTime));
            $borrowPeriod = gmdate("H:i:s", $period);

            // todo: insert returnDateTime into returned equipment
            $returnSQL = "UPDATE BORROW SET returnDateTime = ?, borrowPeriod = ? WHERE borrowID = ?";
            $returnStmt = mysqli_prepare($connect, $returnSQL);
            mysqli_stmt_bind_param($returnStmt,"ssi", $returnDateTime, $borrowPeriod, $borrowID);

            //todo: update the equipIsAvailable status to true
            if (mysqli_stmt_execute($returnStmt)) {
                $statusSQL = "UPDATE equipment SET equipIsAvailable = ? WHERE equipID = ?";
                $statusStmt = mysqli_prepare($connect, $statusSQL);

                mysqli_stmt_bind_param($statusStmt,"is", $returnStatus, $equipID);

                if (mysqli_stmt_execute($statusStmt)) {
                    // todo: update borrowStatus in borrow
                    $rStatus = "RETURNED";
                    $rStatusSQL = "UPDATE borrow SET borrowStatus = ? WHERE borrowID = ?";
                    $rStatusStmt = mysqli_prepare($connect, $rStatusSQL);

                    mysqli_stmt_bind_param($rStatusStmt,"si", $rStatus, $borrowID);

                    if (mysqli_stmt_execute($rStatusStmt)) {
                        echo "<script>alert('Return recorded successfully.'); window.location.href = 'user_equipments.php';</script>";
                    }
                } else {
                    echo "<script>alert('Error updating equipment status: " . mysqli_error($connect) . "')</script>";
                }
            } else {
                echo "<script>alert('Error returning equipment: " . mysqli_error($connect) . "')</script>";
            }
        } else {
            echo "Error: ". mysqli_error($connect) . "";
        }
    }


    

?>