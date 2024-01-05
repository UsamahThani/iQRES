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
    <link rel="stylesheet" href="assets/css/form.css">
    <link rel="stylesheet" href="assets/css/buttoncrud.css">
    <link rel="stylesheet" href="assets/css/reply.css">
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
            <h1>Feedbacks/Reports Reply</h1>
            <div class="contact">
                <div class="contact-list">
                    <?php
                        $replySQL = "SELECT feedback.*, user.userName as studentName FROM FEEDBACK JOIN USER ON feedback.studentID = user.userID WHERE feedback.feedbackID = ".$_GET["feedbackID"];
                        $replyResult = mysqli_query($connect, $replySQL);
        
                        if (mysqli_num_rows($replyResult) > 0) {
                            $row = mysqli_fetch_array($replyResult);
                            $feedbackDate = date("d/m/Y", strtotime($row["feedbackDateTime"]));
                            $feedbackTime = date("H:i:s", strtotime($row["feedbackDateTime"]));
                    ?>
                    <div class="fb-container">
                        <div class="fb-datetime">
                            <div class="fb-date"><?php echo $feedbackDate ?></div>
                            <div class="fb-time"><?php echo $feedbackTime ?></div>
                        </div>
                        <div class="fb-reply-msg">
                            <div class="input-container">
                                <input type="text" id="input" required="" autocomplete="off" readonly value="<?php echo $row["studentName"] ?>">
                                <label for="input" class="label">From</label>
                                <div class="underline"></div>
                            </div>
                            <div class="input-container">
                                <input type="text" id="input" required="" autocomplete="off" readonly value="*<?php echo $row["feedbackSubject"] ?>*">
                                <label for="input" class="label">Subject</label>
                                <div class="underline"></div>
                            </div>
                            <div class="input-container">
                                <textarea id="input" autocomplete="off" rows="6" required readonly><?php echo $row["feedbackMsg"] ?></textarea>
                                <label for="input" class="label">Message</label>
                                <div class="underline"></div>
                            </div>
                        </div>
                        <form action="function_replyFeedback.php" method="post">
                            <div class="input-container">
                                <textarea id="input" autocomplete="off" rows="6" required name="feedbackReply"></textarea>
                                <label for="input" class="label">Reply</label>
                                <div class="underline"></div>
                            </div>
                            <input type="hidden" name="feedbackID" value="<?php echo $row["feedbackID"] ?>">
                            <div class="submit_btn">
                                <button type="submit" class="Btn add">Send 
                                    <svg class="svg add" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.56 3.34a1 1 0 0 0-1-.08l-17 8a1 1 0 0 0-.57.92 1 1 0 0 0 .6.9L8 15.45v6.72L13.84 18l4.76 2.08a.93.93 0 0 0 .4.09 1 1 0 0 0 .52-.15 1 1 0 0 0 .48-.79l1-15a1 1 0 0 0-.44-.89zM18.1 17.68l-5.27-2.31L16 9.17l-7.65 4.25-2.93-1.29 13.47-6.34z"></path></svg>
                                </button>
                                <button type="reset" class="Btn del">Reset
                                    <svg class="svg del" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 16c1.671 0 3-1.331 3-3s-1.329-3-3-3-3 1.331-3 3 1.329 3 3 3z"></path><path d="M20.817 11.186a8.94 8.94 0 0 0-1.355-3.219 9.053 9.053 0 0 0-2.43-2.43 8.95 8.95 0 0 0-3.219-1.355 9.028 9.028 0 0 0-1.838-.18V2L8 5l3.975 3V6.002c.484-.002.968.044 1.435.14a6.961 6.961 0 0 1 2.502 1.053 7.005 7.005 0 0 1 1.892 1.892A6.967 6.967 0 0 1 19 13a7.032 7.032 0 0 1-.55 2.725 7.11 7.11 0 0 1-.644 1.188 7.2 7.2 0 0 1-.858 1.039 7.028 7.028 0 0 1-3.536 1.907 7.13 7.13 0 0 1-2.822 0 6.961 6.961 0 0 1-2.503-1.054 7.002 7.002 0 0 1-1.89-1.89A6.996 6.996 0 0 1 5 13H3a9.02 9.02 0 0 0 1.539 5.034 9.096 9.096 0 0 0 2.428 2.428A8.95 8.95 0 0 0 12 22a9.09 9.09 0 0 0 1.814-.183 9.014 9.014 0 0 0 3.218-1.355 8.886 8.886 0 0 0 1.331-1.099 9.228 9.228 0 0 0 1.1-1.332A8.952 8.952 0 0 0 21 13a9.09 9.09 0 0 0-.183-1.814z"></path></svg>
                                </button>
                            </div>
                        </form>
                    </div>
                    <?php
                        } else {
                            echo "No data found" . mysqli_error($connect);
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