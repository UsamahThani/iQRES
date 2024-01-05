<?php
    session_start();
    include ("function_checkSession.php");
    include ("function_userSidebar.php");
    include ("function_profile.php");
    require "dbconnect.php";
    checkLogin($_SESSION["userId"]);
    $_SESSION["userId"];
    $pageName = "feedback"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/buttoncrud.css">
    <link rel="stylesheet" href="assets/css/feedback.css">
    <link rel="icon" href="https://i.imgur.com/DnvtJhq.png">
    <title>Feedback | iQReS</title>
</head>

<body>

    <div class="container">
        <!-- Sidebar Section -->
        <?php displaySidebar($pageName); ?>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Feedback</h1>
            <div class="contact">
                <div class="contact-list">
                    <div class="fb-form">
                        <div class="fb-title">
                            <h2>Feedback History</h2>
                        </div>
                        <div class="add_btn">
                            <button class="Btn add"  onclick="location.href = 'user_feedback_form.php'">New 
                                <svg class="svg add" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 2H4c-1.103 0-2 .894-2 1.992v12.016C2 17.106 2.897 18 4 18h3v4l6.351-4H20c1.103 0 2-.894 2-1.992V3.992A1.998 1.998 0 0 0 20 2zm-3 9h-4v4h-2v-4H7V9h4V5h2v4h4v2z"></path></svg>
                            </button>
                        </div>
                    </div>
                    <?php
                        //function to check the reply
                        function noReply($replyMsg, $fbID) {
                            if (is_null($replyMsg)){
                                echo "alert('Admin did not reply the feedback yet. Please check again soon.')";
                            } else {
                                echo "location.href='user_feedback_reply.php?feedbackID=" . $fbID . "'";
                            }
                        }
                        $feedbackSQL = "SELECT * FROM feedback WHERE studentID = ". $_SESSION["userId"];
                        $feedbackResult = mysqli_query($connect, $feedbackSQL);
                        $counter = 1;
                        if (mysqli_num_rows($feedbackResult) > 0) {
                            while ($row = mysqli_fetch_array($feedbackResult)) {
                                $feedbackDate = date("d/m/Y", strtotime($row["feedbackDateTime"]));
                                $feedbackTime = date("H:i", strtotime($row["feedbackDateTime"]));
                                $replyMsg = $row["replyMsg"];
                                
                    ?>
                    <div class="fb-container <?php echo is_null($row["replyMsg"]) ? 'no-reply' : 'has-reply'; ?>"" onclick="<?php noReply($row["replyMsg"], $row["feedbackID"]) ?>">
                        
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