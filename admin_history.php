<?php
    session_start();
    include ("function_checkSession.php");
    include ("function_userSidebar.php");
    include ("function_profile.php");
    require "dbconnect.php";
    checkLogin($_SESSION["userId"]);
    $_SESSION["userId"];
    $pageName = "history";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/adminstyle.css">
    <link rel="stylesheet" href="assets/css/table.css">
    <link rel="stylesheet" href="assets/css/buttoncrud.css">
    <link rel="icon" href="https://i.imgur.com/DnvtJhq.png">
    <title>Admin History | iQReS</title>
</head>

<body>
    <div class="container">
        <!-- Sidebar Section -->
        <?php adminSidebar($pageName); ?>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>History</h1>
            <div class="contact">
                <div class="contact-list">
                    <table class="equip-table">
                        <thead>
                            <tr>
                                <!-- <th>No.</th> -->
                                <th class="equipid">EquipID</th>
                                <th class="studentid">Student ID</th>
                                <th class="date">Date</th>
                                <th class="btime">Borrow Time</th>
                                <th class="rtime">Return Time</th>
                                <th class="period">Borrow Period</th>
                                <th class="status">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $counter = 1;
                            $borrowSQL = "SELECT * FROM borrow ORDER BY COALESCE(returnDateTime, borrowDateTime) DESC";
                            $borrowResult = mysqli_query($connect, $borrowSQL);
                            if (mysqli_num_rows($borrowResult) > 0) {
                                while ($row = mysqli_fetch_array($borrowResult)){
                                    $equipID = $row["equipID"];
                                    $studentID = $row["studentID"];
                                    $borrowDate = date("d/m/Y", strtotime($row["borrowDateTime"]));
                                    $borrowTime = date("H:i", strtotime($row["borrowDateTime"]));
                                    
                                    if ($row["returnDateTime"] == NULL) {
                                        $returnTime = "No Data";
                                    } else {
                                        $returnTime = date("H:i", strtotime($row["returnDateTime"]));
                                    }

                                    if ($row["borrowPeriod"] == NULL) {
                                        $period = "No Data";
                                    } else {
                                        $period = date("H:i", strtotime($row["borrowPeriod"]));
                                        // Extract hours and minutes from the formatted time
                                        list($hours, $minutes) = explode(':', $period);

                                        // Display the formatted duration
                                        $formattedDuration = $hours . 'h ' . $minutes . 'm';
                                    }
                                    $status = $row["borrowStatus"];
                                    
                                    $nullPeriod = "No Data";

                                    //change color based on the borrowing status
                                    if ($status == "BORROWING") {
                                        $statusColor = "red";
                                    } else {
                                        $statusColor = "green";
                                    }
                                    
                        ?>
                        <tr>
                            <!-- <td><?php echo $counter ?></td> -->
                            <td><?php echo $equipID ?></td>
                            <td><a href="admin_student_edit.php?userID=<?php echo $studentID ?>"  style="color: #934eed;"><?php echo $studentID ?></a></td>
                            <td><?php echo $borrowDate ?></td>
                            <td><?php echo $borrowTime ?></td>
                            <td><?php echo $returnTime ?></td>
                            <td>
                                <?php
                                    if ($row["borrowPeriod"] == NULL) {
                                        echo $nullPeriod;
                                    } else {
                                        echo $formattedDuration;
                                    }
                                ?>
                            </td>
                            <td style="color: <?php echo $statusColor ?>"><?php echo $status ?></td>
                        </tr>
                        <?php
                                    $counter++;
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
        <!-- End of Main Content -->

        <!-- Right Section -->
        <?php echo rightSection() ?>
    </div>

    <script src="assets/js/index.js"></script>
</body>

</html>