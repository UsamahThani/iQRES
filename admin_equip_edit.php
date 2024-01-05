
<?php
    session_start();
    include ("function_checkSession.php");
    include ("function_userSidebar.php");
    include ("function_profile.php");
    require "dbconnect.php";
    checkLogin($_SESSION["userId"]);
    $_SESSION["userId"];
    $pageName = "equipment";


    if (!empty($_GET["qrText"])) {
        $equipID = strtoupper($_GET["qrText"]);
    } else {
        $equipID = $_GET["equipID"];
    }

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
    <title>Admin Edit <?php echo $equipID ?> Equipments | iQReS</title>
</head>

<body>
    <div class="container">
        <!-- Sidebar Section -->
        <?php adminSidebar($pageName); ?>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Edit <?php echo $equipID ?> Details</h1>
            <!-- New Users Section -->
            <div class="contact">
                <div class="contact-list">

                    <h2><?php echo $equipID ?> Update Form</h2>
                    <div class="add_equip">
                        <?php
                            //retrieve equipment data
                            $equipSQL = "SELECT * FROM equipment WHERE equipID = '$equipID'";
                            $equipResult = mysqli_query($connect, $equipSQL);
                            
                            if ($equipResult) {
                                if ($row = mysqli_fetch_array($equipResult)) {
                                    $equipName = $row["equipName"];
                                    $equipRegisterDate = $row["equipRegisterDate"];
                                    $equipPurchaseDate = $row["equipPurchaseDate"];
                                    $equipCondition = $row["equipCondition"];
                                    $equipCategory = $row["equipCategory"];
                                } else {
                                    echo "<script>alert('Equipment with ID $equipID does not exist.'); history.back();</script>";
                                }
                            }

                            //check the equipment condition
                            if ($equipCondition == "Good") {
                                $goodSelected = "selected";
                                $brokenSelected = " ";
                            } else if ($equipCondition == "Broken") {
                                $brokenSelected = "selected";
                                $goodSelected = " ";
                            }
                        ?>
                        <form action="function_updateEquipment.php" method="post">
                            <div class="input-container">
                                <input type="text" id="input" required="" autocomplete="off" name="equipID" readonly value="<?php echo $equipID ?>">
                                <label for="input" class="label">Equipment ID</label>
                                <div class="underline"></div>
                            </div>
                            <div class="input-container">
                                <input type="text" id="input" required="" autocomplete="off" name="equipName" value="<?php echo $equipName ?>">
                                <label for="input" class="label">Equipment Name</label>
                                <div class="underline"></div>
                            </div>
                            <div class="input-container">
                                <input type="date" id="registerDate" required="" autocomplete="off" name="equipRegisterDate" readonly value="<?php echo $equipRegisterDate ?>">
                                <label for="registerDate" class="label">Register Date</label>
                                <div class="underline"></div>
                            </div>
                            <div class="input-container">
                                <input type="date" id="purchaseDate" required="" autocomplete="off" name="equipPurchaseDate" value="<?php echo $equipPurchaseDate ?>">
                                <label for="purchaseDate" class="label">Purchase Date</label>
                                <div class="underline"></div>
                            </div>
                            <input type="hidden" name="equipCategory" value="<?php echo $equipCategory?>">
                            <div class="input-container">
                                <span>Equipment Condition</span>
                                <div class="select">
                                    <select name="equipCondition">
                                    <option value="Good" <?php echo $goodSelected ?>>Good</option>
                                    <option value="Broken" <?php echo $brokenSelected ?>>Broken</option>
                                    </select>
                                </div>
                            </div>
                            <div class="submit_btn">
                                <button type="submit" id="send" class="Btn add" name="submit">Add 
                                    <svg class="svg add" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path></svg>
                                </button>
                                <button type="reset" class="Btn del" id="reset">Reset
                                    <svg class="svg del" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 16c1.671 0 3-1.331 3-3s-1.329-3-3-3-3 1.331-3 3 1.329 3 3 3z"></path><path d="M20.817 11.186a8.94 8.94 0 0 0-1.355-3.219 9.053 9.053 0 0 0-2.43-2.43 8.95 8.95 0 0 0-3.219-1.355 9.028 9.028 0 0 0-1.838-.18V2L8 5l3.975 3V6.002c.484-.002.968.044 1.435.14a6.961 6.961 0 0 1 2.502 1.053 7.005 7.005 0 0 1 1.892 1.892A6.967 6.967 0 0 1 19 13a7.032 7.032 0 0 1-.55 2.725 7.11 7.11 0 0 1-.644 1.188 7.2 7.2 0 0 1-.858 1.039 7.028 7.028 0 0 1-3.536 1.907 7.13 7.13 0 0 1-2.822 0 6.961 6.961 0 0 1-2.503-1.054 7.002 7.002 0 0 1-1.89-1.89A6.996 6.996 0 0 1 5 13H3a9.02 9.02 0 0 0 1.539 5.034 9.096 9.096 0 0 0 2.428 2.428A8.95 8.95 0 0 0 12 22a9.09 9.09 0 0 0 1.814-.183 9.014 9.014 0 0 0 3.218-1.355 8.886 8.886 0 0 0 1.331-1.099 9.228 9.228 0 0 0 1.1-1.332A8.952 8.952 0 0 0 21 13a9.09 9.09 0 0 0-.183-1.814z"></path></svg>
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