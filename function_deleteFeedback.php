<?php
    require "dbconnect.php";

    $feedbackID = $_GET["feedbackID"];
    // Delete feedback
    $deleteFeedbackSQL = "DELETE FROM FEEDBACK WHERE feedbackID = ?";
        
    $deleteStmt = mysqli_prepare($connect, $deleteFeedbackSQL);
    mysqli_stmt_bind_param($deleteStmt, 'i', $feedbackID);

    if (mysqli_stmt_execute($deleteStmt)) {
        echo "<script>alert('Feedback deleted successfully!'); location.href='admin_feedback.php';</script>";
    } else {
        echo "<script>alert('Deleting feedback failed!: " . mysqli_error($connect) . " '); history.back();</script>";
    }

    mysqli_stmt_close($deleteStmt);

?>