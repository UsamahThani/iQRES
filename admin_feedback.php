<?php
    session_start();
    include ("function_checkSession.php");
    include ("function_userSidebar.php");
    include ("function_profile.php");
    require "dbconnect.php";
    checkLogin($_SESSION["userId"]);
    $_SESSION["userId"];
    $pageName = "feedback";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/adminstyle.css">
    <link rel="stylesheet" href="assets/css/feedback.css">
    <link rel="icon" href="https://i.imgur.com/DnvtJhq.png">
    <title>Admin Feedback | iQReS</title>
</head>

<body>
    <div class="container">
        <!-- Sidebar Section -->
        <?php adminSidebar($pageName); ?>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Feedbacks/Reports</h1>
            <div class="contact">
                <div class="contact-list">
                    <?php
                        function replyCheck($replyMsg, $fbID) {
                            if (is_null($replyMsg)) {
                                echo "location.href='admin_feedback_reply.php?feedbackID=" . $fbID . "'";
                            } else {
                                echo "location.href='admin_feedback_display.php?feedbackID=" . $fbID . "'";
                            }
                        }


                        $feedbackSQL = "SELECT * FROM feedback ORDER BY feedbackStatus='PENDING' DESC, feedbackDateTime ASC";
                        $feedbackResult = mysqli_query($connect, $feedbackSQL);
                        $counter = 1;
                        if (mysqli_num_rows($feedbackResult) > 0) {
                            while ($row = mysqli_fetch_array($feedbackResult)) {
                                $feedbackDate = date("d/m/Y", strtotime($row["feedbackDateTime"]));
                                $feedbackTime = date("H:i", strtotime($row["feedbackDateTime"]));
                    ?>
                    <div class="fb-container" onclick="<?php replyCheck($row["replyMsg"], $row["feedbackID"]) ?>">
                        
                        <div class="fb-content">
                            <div class="fb-num">
                                <h2><?php echo $counter ?></h2>
                            </div>
                            <div class="fb-subject">
                                <h2><?php echo $row["feedbackSubject"] ?></h2>
                            </div>
                            <div class="fb-datetime">
                                <h3><?php echo $feedbackDate ?></h3>
                                <h3><?php echo $feedbackTime ?></h3>
                            </div>
                        </div>
                        <div class="fb-status">
                            <?php
                                if ($row["feedbackStatus"] == "PENDING") {
                                    $textColor = "red";
                                } else if ($row["feedbackStatus"] == "REPLIED") {
                                    $textColor = "green";
                                }
                            ?>
                            <h2 style="color: <?php echo $textColor; ?>"><?php echo $row["feedbackStatus"] ?></h2>
                        </div>

                    </div>
                    <?php
                                $counter++;
                            }
                        } else {
                            ?>
                                <div class="fb-nocontent">
                                    No messages found.
                                </div>
                            <?php
                        }
                    ?>
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