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
                        <div class="input-container">
                            <textarea id="input" autocomplete="off" rows="6" required name="feedbackReply" readonly><?php echo $row["replyMsg"] ?></textarea>
                            <label for="input" class="label">Reply</label>
                            <div class="underline"></div>
                        </div>
                        <div class="submit_btn">
                            <button class="Btn add" onclick="window.location.href='admin_feedback.php'">Back 
                                <svg class="svg add" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21 11H6.414l5.293-5.293-1.414-1.414L2.586 12l7.707 7.707 1.414-1.414L6.414 13H21z"></path></svg>
                            </button>
                            <button class="Btn del" onclick="window.location.href='function_deleteFeedback.php?feedbackID=<?php echo $_GET['feedbackID']; ?>'">Delete
                                <svg class="svg del" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                            </button>
                        </div>
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