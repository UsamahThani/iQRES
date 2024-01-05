<?php
    $qrText = strtoupper($_GET["qrText"]);
    session_start();
    include ("function_checkSession.php");
    include ("function_userSidebar.php");
    include ("function_profile.php");
    require "dbconnect.php";
    checkLogin($_SESSION["userId"]);
    $_SESSION["userId"];
    $pageName = "equipment"
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
    <link rel="stylesheet" href="assets/css/datepicker.css">
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
            <h1>Borrowing/Returning Equipment</h1>
            <div class="contact">
                <div class="contact-list">
                    <?php
                        //prevent sql injection
                        $qrText = mysqli_real_escape_string ($connect, $qrText);

                        $equipIDSQL = "SELECT * FROM equipment WHERE equipID = '$qrText'";
                        $equipIDResult = mysqli_query($connect, $equipIDSQL);

                        if ($equipIDResult) {
                            //if there is equip id same as qrText
                            if (mysqli_num_rows($equipIDResult) > 0) {
                                
                                //check if the equipment borrowed or not
                                $row = mysqli_fetch_array($equipIDResult);

                                if ($row["equipIsAvailable"]) {
                                    //if equipment is available, display borrow section
                                    ?>


                                    <h2>Borrowing Equipment Confirmation</h2>
                                    <div class="add_equip">
                                        <form action="function_borrowReturn.php" method="post">
                                            <div class="input-container">
                                                <input type="text" id="input" name="equipID" required="" autocomplete="off" readonly value="<?php echo $qrText?>">
                                                <label for="input" class="label">Equipment ID</label>
                                                <div class="underline"></div>
                                            </div>
                                            <div class="input-container">
                                                <input type="text" id="input" name="equipName" required="" autocomplete="off" readonly value="<?php echo $row["equipName"] ?>">
                                                <label for="input" class="label">Equipment Name</label>
                                                <div class="underline"></div>
                                            </div>
                                            <div class="input-container">
                                                <input type="text" id="input" name="equipCategory" required="" autocomplete="off" readonly value="<?php echo $row["equipCategory"] ?>">
                                                <label for="input" class="label">Equipment Category</label>
                                                <div class="underline"></div>
                                            </div>
                                            <div class="input-container">
                                                <input type="text" id="input" name="equipCondition" required="" autocomplete="off" readonly value="<?php echo $row["equipCondition"] ?>">
                                                <label for="input" class="label">Equipment Condition</label>
                                                <div class="underline"></div>
                                            </div>
                                            <input type="hidden" name="formType" value="borrowForm">
                                            <div class="submit_btn">
                                                <button type="submit" class="Btn add long">Borrow
                                                    <svg class="svg add" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M14 13H8V5H6v9a1 1 0 0 0 1 1h7v3l5-4-5-4v3z"></path></svg>
                                                </button>
                                                <button type="button" class="Btn del" onclick="location.href='user_equipments.php'">Back 
                                                    <svg class="svg add" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21 11H6.414l5.293-5.293-1.414-1.414L2.586 12l7.707 7.707 1.414-1.414L6.414 13H21z"></path></svg>
                                                </button>
                                            </div>
                                        </form>
                                    </div>


                                    <?php
                                } else {
                                    $borrowSQL = "SELECT * FROM borrow WHERE equipID = '$qrText' AND studentID = " . $_SESSION["userId"];
                                    $borrowResult = mysqli_query($connect, $borrowSQL);

                                    if ($borrowResult && mysqli_num_rows($borrowResult) > 0) {
                                        //if the borrowed equipment is from the current user, display return section


                                        ?>
                                        <h2>Returning Equipment Confirmation</h2>
                                        <div class="add_equip">
                                            <form action="function_borrowReturn.php" method="post">
                                                <div class="input-container">
                                                    <input type="text" id="input" name="equipID" required="" autocomplete="off" readonly value="<?php echo $qrText?>">
                                                    <label for="input" class="label">Equipment ID</label>
                                                    <div class="underline"></div>
                                                </div>
                                                <div class="input-container">
                                                    <input type="text" id="input" name="equipName" required="" autocomplete="off" readonly value="<?php echo $row["equipName"] ?>">
                                                    <label for="input" class="label">Equipment Name</label>
                                                    <div class="underline"></div>
                                                </div>
                                                <div class="input-container">
                                                    <input type="text" id="input" name="equipCategory" required="" autocomplete="off" readonly value="<?php echo $row["equipCategory"] ?>">
                                                    <label for="input" class="label">Equipment Category</label>
                                                    <div class="underline"></div>
                                                </div>
                                                <div class="input-container">
                                                    <input type="text" id="input" name="equipCondition" required="" autocomplete="off" readonly value="<?php echo $row["equipCondition"] ?>">
                                                    <label for="input" class="label">Equipment Condition</label>
                                                    <div class="underline"></div>
                                                </div>
                                                <input type="hidden" name="formType" value="returnForm">
                                                <div class="submit_btn">
                                                    <button type="submit" class="Btn add long">Return
                                                        <svg class="svg add" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M14 13H8V5H6v9a1 1 0 0 0 1 1h7v3l5-4-5-4v3z"></path></svg>
                                                    </button>
                                                    <button type="button" class="Btn del" onclick="location.href='user_equipments.php'">Back 
                                                        <svg class="svg add" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21 11H6.414l5.293-5.293-1.414-1.414L2.586 12l7.707 7.707 1.414-1.414L6.414 13H21z"></path></svg>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <?php


                                    } else {
                                        echo "<script>alert('Equipment is borrowed by another user.'); history.back();</script>";
                                    }
                                }

                            } else {
                                echo "<script>alert('Equipment with ID $qrText does not exist.'); history.back();</script>";
                            }
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