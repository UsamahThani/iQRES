<?php
    session_start();
    include ("function_checkSession.php");
    include ("function_userSidebar.php");
    include ("function_profile.php");
    require "dbconnect.php";
    checkLogin($_SESSION["userId"]);
    $_SESSION["userId"];
    $pageName = "equipment";

    //search function
    if (isset($_POST["search"])) {
        $query = $_POST["query"];
        $searchSQL = "SELECT ce.cateName AS equipmentCategory, COUNT(e.equipCategory) AS quantity
                      FROM categoryequipment ce
                      LEFT JOIN equipment e ON ce.cateName = e.equipCategory
                      WHERE CONCAT(e.equipName, e.equipCategory) LIKE '%$query%'
                      GROUP BY ce.cateName";
        $totalSQL = "SELECT COUNT(*) AS totalQuantity FROM equipment WHERE CONCAT(equipName, equipCategory) LIKE '%$query%'";
        $filter = mysqli_query($connect, $searchSQL);
        $totalResult = mysqli_query($connect, $totalSQL);
    } else {
        $searchSQL = "SELECT ce.cateName AS equipmentCategory, COUNT(e.equipCategory) AS quantity
                      FROM categoryequipment ce
                      LEFT JOIN equipment e ON ce.cateName = e.equipCategory
                      GROUP BY ce.cateName";
        $totalSQL = "SELECT COUNT(*) AS totalQuantity FROM equipment";
        $filter = mysqli_query($connect, $searchSQL);
        $totalResult = mysqli_query($connect, $totalSQL);
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
    <link rel="stylesheet" href="assets/css/qrscanner.css">
    <link rel="stylesheet" href="assets/css/table.css">
    <link rel="stylesheet" href="assets/css/buttoncrud.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="https://i.imgur.com/DnvtJhq.png">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Admin Equipment Page | iQReS</title>
</head>

<body>
    <div class="container">
        <!-- Sidebar Section -->
        <?php adminSidebar($pageName); ?>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Sport Equipments</h1>
            <!-- New Users Section -->
            <div class="scanner">
                <div class="qr-scanner">
                    <div class="camera">
                        <div class="video-container">
                            <video id="preview" playsinline></video>
                            <div class="qr-square"></div>
                        </div>
                    </div>
                    <div class="option">
                        <form action="admin_equip_edit.php" method="get">
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
                <div class="contact-list">
                    <div class="search_add">
                        <form class="searchBox" method="post" action="">

                            <input class="searchInput" type="text" name="query" placeholder="Search something" autocomplete="off">
                            <button class="searchButton" type="submit" name="search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none">
                <g clip-path="url(#clip0_2_17)">
                    <g filter="url(#filter0_d_2_17)">
                    <path d="M23.7953 23.9182L19.0585 19.1814M19.0585 19.1814C19.8188 18.4211 20.4219 17.5185 20.8333 16.5251C21.2448 15.5318 21.4566 14.4671 21.4566 13.3919C21.4566 12.3167 21.2448 11.252 20.8333 10.2587C20.4219 9.2653 19.8188 8.36271 19.0585 7.60242C18.2982 6.84214 17.3956 6.23905 16.4022 5.82759C15.4089 5.41612 14.3442 5.20435 13.269 5.20435C12.1938 5.20435 11.1291 5.41612 10.1358 5.82759C9.1424 6.23905 8.23981 6.84214 7.47953 7.60242C5.94407 9.13789 5.08145 11.2204 5.08145 13.3919C5.08145 15.5634 5.94407 17.6459 7.47953 19.1814C9.01499 20.7168 11.0975 21.5794 13.269 21.5794C15.4405 21.5794 17.523 20.7168 19.0585 19.1814Z" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" shape-rendering="crispEdges"></path>
                    </g>
                </g>
                <defs>
                    <filter id="filter0_d_2_17" x="-0.418549" y="3.70435" width="29.7139" height="29.7139" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                    <feOffset dy="4"></feOffset>
                    <feGaussianBlur stdDeviation="2"></feGaussianBlur>
                    <feComposite in2="hardAlpha" operator="out"></feComposite>
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"></feColorMatrix>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2_17"></feBlend>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2_17" result="shape"></feBlend>
                    </filter>
                    <clipPath id="clip0_2_17">
                    <rect width="28.0702" height="28.0702" fill="white" transform="translate(0.403503 0.526367)"></rect>
                    </clipPath>
                </defs>
                            </svg>
                            </button>
                        </form>
                        <div class="add_btn">
                            <button class="Btn add"  onclick="location.href = 'admin_equipCategory_add.php'">Add 
                                <svg class="svg add" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path></svg>
                            </button>
                        </div>
                    </div>
                    <table class="equipment-table">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Equipment Category</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $counter = 1;
                                while ($row = mysqli_fetch_array($filter)) {
                            ?>
                        <tr>
                            <td><?php echo $counter ?></td>
                            <td><?php echo $row['equipmentCategory'] ?></td>
                            <td><?php echo $row['quantity'] ?></td>
                            <td>
                                <div class="action_btn equipment">
                                    <div>
                                        <button class="Btn more" onclick="location.href = 'admin_equip_list.php?equipCategory=<?php echo $row['equipmentCategory'] ?>'">More 
                                            <svg class="svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                                        </button>
                                    </div>
                                    <div>
                                        <button class="Btn edit" onclick="window.location.href = 'admin_equipCategory_edit.php?equipCategory=<?php echo $row['equipmentCategory'] ?>'">Details 
                                        <svg class="svg" viewBox="0 0 512 512">
                                            <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                            <?php
                                    $counter++;
                                }

                                //total row
                                $totalRow = mysqli_fetch_array($totalResult);
                            ?>    
                        <tr>
                            <td colspan="2">Total</td>
                            <td><?php echo $totalRow['totalQuantity'] ?> units</td>
                            <td></td>
                        </tr>
                        <tbody>
                    </table>
                </div>
            </div>
            <!-- End of New Users Section -->

        </main>
        <!-- End of Main Content -->

        <!-- Right Section -->
        <?php echo rightSection() ?>
    </div>

    <script src="assets/js/index.js"></script>
    <script src="assets/js/adminqrscanner.js"></script>
</body>

</html>