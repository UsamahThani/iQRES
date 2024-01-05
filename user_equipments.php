<?php
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
    <link rel="stylesheet" href="assets/css/buttoncrud.css">
    <link rel="stylesheet" href="assets/css/qrscanner.css">
    <link rel="icon" href="https://i.imgur.com/DnvtJhq.png">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Equipment Page | iQReS</title>
</head>

<body>

    <div class="container">
        <!-- Sidebar Section -->
        <?php displaySidebar($pageName); ?>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Scanner and Equipment List</h1>
            
            <div class="scanner">
                <div class="qr-scanner">
                    <div class="camera">
                        <div class="video-container">
                            <video id="preview" playsinline></video>
                            <div class="qr-square"></div>
                        </div>
                    </div>
                    <div class="option">
                        <form action="user_equipment_borrowReturn.php" method="get">
                            <label>Select Camera:</label><br>
                            <select id="cameraSelection" class="form-control"></select><br><br>

                            <label>Equipment ID:</label><br>
                            <input type="text" name="qrText" id="text" autocomplete="off" required placeholder="Scan QR or insert ID manually" class="form-control"><br><br>
                            <div class="submit_btn">
                                <button type="submit" class="Btn add long">Proceed
                                    <svg class="svg add" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.56 3.34a1 1 0 0 0-1-.08l-17 8a1 1 0 0 0-.57.92 1 1 0 0 0 .6.9L8 15.45v6.72L13.84 18l4.76 2.08a.93.93 0 0 0 .4.09 1 1 0 0 0 .52-.15 1 1 0 0 0 .48-.79l1-15a1 1 0 0 0-.44-.89zM18.1 17.68l-5.27-2.31L16 9.17l-7.65 4.25-2.93-1.29 13.47-6.34z"></path></svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="contact">
                <h2>Equipment List</h2>
                <div class="contact-list">
                    <table class="equip-table">
                        <tr>
                            <th>No.</th>
                            <th>Equipment Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                        </tr>
                        <?php
                            $equipSQL = "SELECT equipName, equipCategory, COUNT(*) as equipQtt FROM equipment GROUP BY equipName, equipCategory";
                            $equipResult = mysqli_query($connect, $equipSQL);
                            $counter = 1;

                            if (mysqli_num_rows($equipResult) > 0) {
                                while ($row = mysqli_fetch_assoc($equipResult)) {
                        ?>
                        <tr>
                            <td><?php echo $counter ?></td>
                            <td><?php echo $row["equipName"] ?></td>
                            <td><?php echo $row["equipCategory"] ?></td>
                            <td><?php echo $row["equipQtt"] ?></td>
                        </tr>
                        <?php
                            $counter++;
                                }
                            } else {
                                echo "Data not found.";
                            }
                        ?>
                        
                    </table>
                </div>
            </div>
        </main>
        <!-- End of Main Content -->

        <!-- Right Section -->
        <?php echo rightSection() ?>
    </div>

    <script src="assets/js/index.js"></script>
    <script src="assets/js/qrscanner.js"></script>
   
    
</body>

</html>