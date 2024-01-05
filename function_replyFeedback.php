<?php
    require "dbconnect.php";
    session_start();

    $fbReply = $_POST["feedbackReply"];
    $adminID = $_SESSION["userId"];
    $feedbackID = $_POST["feedbackID"]; // Assuming you have a way to pass the feedback ID from the form

    date_default_timezone_set('Asia/Kuala_Lumpur');
    $replyDateTime = date("Y-m-d H:i:s");

    // Update feedback table with admin reply
    $updateFeedbackSQL = "UPDATE FEEDBACK SET adminID = ?, replyMsg = ?, replyDateTime = ?, feedbackStatus = 'REPLIED' WHERE feedbackID = ?";
    
    $updateStmt = mysqli_prepare($connect, $updateFeedbackSQL);
    mysqli_stmt_bind_param($updateStmt, 'sssi', $adminID, $fbReply, $replyDateTime, $feedbackID);

    if (mysqli_stmt_execute($updateStmt)) {
        echo "<script>alert('Reply sent successfully.'); window.location.href = 'admin_feedback.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($connect) . "')</script>";
    }

    mysqli_stmt_close($updateStmt);
    mysqli_close($connect);
?>
