
<?php
    session_start();
    include ("function_checkSession.php");
    include ("function_userSidebar.php");
    include ("function_profile.php");
    require "dbconnect.php";
    checkLogin($_SESSION["userId"]);
    $_SESSION["userId"];
    $pageName = "equipment";

    $equipCategory = $_GET["equipCategory"];
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
    <link rel="stylesheet" href="assets/css/datepicker.css">
    <link rel="stylesheet" href="assets/css/qrgenerator.css">
    <link rel="icon" href="https://i.imgur.com/DnvtJhq.png">
    <title>Admin Edit <?php echo $equipCategory ?>  | iQReS</title>
</head>

<body>
    <div class="container">
        <!-- Sidebar Section -->
        <?php adminSidebar($pageName); ?>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Edit <?php echo $equipCategory ?> Details</h1>
            <!-- New Users Section -->
            <div class="contact">
                <div class="contact-list">

                    <h2><?php echo $equipCategory ?> Update Form</h2>
                    <div class="add_equip">
                        <?php
                            //retrieve equipment data
                            $equipSQL = "SELECT * FROM categoryequipment WHERE cateName = '$equipCategory'";
                            $equipResult = mysqli_query($connect, $equipSQL);
                            
                            if ($equipResult) {
                                if ($row = mysqli_fetch_array($equipResult)) {
                                    $cateID = $row["cateID"];
                                    $cateRegisterBy = $row["cateRegisterBy"];
                                }
                            }
                        ?>
                        <form action="" method="post">
                            <div class="input-container">
                                <input type="text" id="input" required="" autocomplete="off" name="cateID" readonly value="<?php echo $cateID ?>">
                                <label for="input" class="label">Category ID</label>
                                <div class="underline"></div>
                            </div>
                            <div class="input-container">
                                <input type="text" id="input" required="" autocomplete="off" name="cateName" readonly value="<?php echo $equipCategory ?>">
                                <label for="input" class="label">Category Name</label>
                                <div class="underline"></div>
                            </div>
                            <div class="input-container">
                                <input type="text" id="input" required="" autocomplete="off" name="cateRegisterBy" readonly value="<?php echo $cateRegisterBy ?>">
                                <label for="input" class="label">Category Registered By</label>
                                <div class="underline"></div>
                            </div>
                            
                            <div class="submit_btn category">
                                <button type="reset" class="Btn del" onclick="window.location.href='function_deleteCategory.php?cateID=<?php echo $cateID ?>'">Delete
                                <svg class="svg del" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6 7H5v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7H6zm4 12H8v-9h2v9zm6 0h-2v-9h2v9zm.618-15L15 2H9L7.382 4H3v2h18V4z"></path></svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End of New Users Section -->

        </main>
        <!-- End of Main Content -->

        <!-- Right Section -->
        <?php echo rightSection() ?>
    </div>

    <script src="assets/js/index.js"></script>

</body>
</html>