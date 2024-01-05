<?php
    require "dbconnect.php";
    function generateBorrowID() {
        global $connect;
        do {
            $borrowID = random_int(10000,99999);
            $idSQL = "SELECT borrowID FROM BORROW WHERE borrowID = $borrowID";
            $idResult = mysqli_query($connect, $idSQL);

            if (mysqli_num_rows($idResult) == 0) {
                break;
            }

        } while (true);

        return $borrowID;
    }

    function findBorrowID($equipID){
        global $connect;

        // Ensure that $_SESSION['userId'] is set before using it
        if (!isset($_SESSION['userId'])) {
            // Handle the case where the userId is not set, throw an error, or return an appropriate value
            return null;
        }

        // Prepare and execute the SQL query
        $borrowIDSQL = "SELECT borrowID FROM borrow WHERE studentID = ? AND equipID = ? AND borrowStatus = 'BORROWING'";
        $borrowIDStmt = mysqli_prepare($connect, $borrowIDSQL);
        mysqli_stmt_bind_param($borrowIDStmt, "ii", $_SESSION['userId'], $equipID);
        mysqli_stmt_execute($borrowIDStmt);
        $borrowIDResult = mysqli_stmt_get_result($borrowIDStmt);

        // Check if a row is returned
        if ($row = mysqli_fetch_assoc($borrowIDResult)) {
            // Return the borrowID
            return $row['borrowID'];
        } else {
            // Return null or handle the case where no matching row is found
            return null;
        }
    }
?>