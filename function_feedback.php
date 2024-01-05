<?php
    session_start();
    include ("function_checkSession.php");
    require "dbconnect.php";
    checkLogin($_SESSION["userId"]);

    $studentID = $_POST["userID"];
    $feedbackSubject = $_POST["feedbackSubject"];
    $feedbackMsg = $_POST["feedbackMsg"];

    date_default_timezone_set('Asia/Kuala_Lumpur');
    $feedbackDateTime = date("Y-m-d H:i:s");

    //generate feedbackID
    $feedbackID = generateUniqueID();

    //Function to generate random but unique id
    function generateUniqueID() {
        global $connect;

        do {
            $feedbackID = random_int(10000,99999);
            $idSQL = "SELECT * FROM FEEDBACK WHERE feedbackID = $feedbackID";
            $idResult = mysqli_query($connect, $idSQL);

            //Check if the generated ID already exists
            if (mysqli_num_rows($idResult) == 0) {
                //the ID is unique, break the loop
                break;
            }

            //if the ID already exists, regenerate a new one and tru again
        } while (true);

        return $feedbackID;

    }

    //insert data to db
    $feedbackSQL = "INSERT INTO FEEDBACK (feedbackID, studentID, feedbackSubject, feedbackMsg, feedbackDateTime)
    VALUES (?, ?, ?, ?, NOW())";

    $stmt = mysqli_prepare($connect, $feedbackSQL);
    mysqli_stmt_bind_param($stmt,'isss', $feedbackID, $studentID, $feedbackSubject, $feedbackMsg);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Feedback sent successfully.'); window.location.href = 'user_feedback.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($connect) . "')</script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connect);

?>