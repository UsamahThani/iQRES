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
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/form.css">
    <link rel="stylesheet" href="assets/css/buttoncrud.css">
    <link rel="stylesheet" href="assets/css/reply.css">
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
            <?php
                $replySQL = "SELECT feedback.*, user.userName as adminName FROM FEEDBACK JOIN USER ON feedback.adminID = user.userID WHERE feedback.feedbackID = ".$_GET["feedbackID"];
                $replyResult = mysqli_query($connect, $replySQL);

                if (mysqli_num_rows($replyResult) > 0) {
                    $row = mysqli_fetch_array($replyResult);
                    $feedbackDate = date("d/m/Y", strtotime($row["feedbackDateTime"]));
                    $feedbackTime = date("H:i:s", strtotime($row["feedbackDateTime"]));
            ?>
            <h1>Feedback</h1>
            <div class="contact">
                <div class="contact-list">
                    <div class="fb-container">
                        <div class="fb-datetime">
                            <div class="fb-date"><?php echo $feedbackDate ?></div>
                            <div class="fb-time"><?php echo $feedbackTime ?></div>
                        </div>
                        <div class="fb-reply-msg">
                            <div class="input-container">
                                <input type="text" id="input" required="" autocomplete="off" readonly value="<?php echo $row["adminName"] ?>">
                                <label for="input" class="label">From</label>
                                <div class="underline"></div>
                            </div>
                            <div class="input-container">
                                <input type="text" id="input" required="" autocomplete="off" readonly value="<?php echo $row["feedbackSubject"] ?>">
                                <label for="input" class="label">Subject</label>
                                <div class="underline"></div>
                            </div>
                            <div class="input-container">
                                <textarea id="input" autocomplete="off" rows="6" required readonly><?php echo $row["feedbackMsg"] ?></textarea>
                                <label for="input" class="label">Message</label>
                                <div class="underline"></div>
                            </div>
                            <div class="input-container">
                                <textarea id="input" autocomplete="off" rows="6" required readonly><?php echo $row["replyMsg"] ?></textarea>
                                <label for="input" class="label">Reply</label>
                                <div class="underline"></div>
                            </div>
                        </div>
            <?php
                } else {
                    echo "No data found" . mysqli_error($connect);
                }
            ?>
                        <div class="submit_btn">
                            <button class="Btn add" onclick="history.back()">Back 
                                <svg class="svg add" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21 11H6.414l5.293-5.293-1.414-1.414L2.586 12l7.707 7.707 1.414-1.414L6.414 13H21z"></path></svg>
                            </button>
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