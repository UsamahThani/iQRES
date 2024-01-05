<?php
    session_start();
    include ("function_checkSession.php");
    include ("function_userSidebar.php");
    include ("function_profile.php");
    require "dbconnect.php";
    checkLogin($_SESSION["userId"]);
    $_SESSION["userId"];
    $pageName = "history"
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="https://i.imgur.com/DnvtJhq.png">
    <title>History | iQReS</title>
</head>

<body>

    <div class="container">
        <!-- Sidebar Section -->
        <?php displaySidebar($pageName); ?>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Equipment Borrowing History</h1>
            <div class="contact">
                <div class="contact-list">
                    <div class="borrow-history">
                        <div class="equip-table-container">
                        <table class="equip-table">
                            <thead>
                                <tr>
                                    <th>Equipment</th>
                                    <th>Date</th>
                                    <th>Borrow Time</th>
                                    <th>Return Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $borrowSQL = "SELECT borrow.*, equipment.* FROM borrow JOIN equipment ON borrow.equipID = equipment.equipID WHERE borrow.studentID = ".$_SESSION["userId"] . " AND borrow.borrowStatus = 'RETURNED'";
                                    $borrowResult = mysqli_query($connect, $borrowSQL);
                                    if (mysqli_num_rows($borrowResult) > 0) {
                                        while ($row = mysqli_fetch_array($borrowResult)) {
                                            $equipName = $row["equipName"];
                                            $equipCategory = $row["equipCategory"];

                                            //Extract date and time
                                            $equipDate = date("d/m/Y", strtotime($row["borrowDateTime"]));
                                            $equipTime = date("H:i", strtotime($row["borrowDateTime"]));
                                            $returnTime = date("H:i", strtotime($row["returnDateTime"]));
                                ?>
                                <tr>
                                    <td class="left-align"><?php echo $equipCategory . " | " . $equipName;  ?></td>
                                    <td><?php echo $equipDate ?></td>
                                    <td><?php echo $equipTime ?></td>
                                    <td><?php echo $returnTime ?></td>
                                </tr>
                                <?php
                                        }
                                    } else {
                                        ?>
                                            <tr>
                                                <td colspan="3">No borrowing information</td>
                                            </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
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