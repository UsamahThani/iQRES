<?php
    session_start();
    include ("function_checkSession.php");
    include ("function_userSidebar.php");
    include ("function_profile.php");
    include ("function_ImgurAPI.php");
    require "dbconnect.php";
    checkLogin($_SESSION["userId"]);
    $_SESSION["userId"];
    $pageName = "equipment";

    //when user click the qr image
    if (isset($_GET["downloadQR"])) {
        $imgurLink = $_GET["imgurLink"];
        $equipID = $_GET["equipID"];
        DownloadImgur($imgurLink, $equipID);
    }

    //get the equipCategory
    $equipCategory = $_GET["equipCategory"];
    //search function
    if (isset($_POST["search"])) {
        $query = $_POST["query"];
        $searchSQL = "SELECT * FROM equipment WHERE equipCategory = '$equipCategory' AND CONCAT(equipID, equipName, equipRegisterDate, equipPurchaseDate) LIKE '%$query%' GROUP BY equipID";
        $filter = mysqli_query($connect, $searchSQL);
    } else {
        $searchSQL = "SELECT * FROM equipment WHERE equipCategory = '$equipCategory' GROUP BY equipID";
        $filter = mysqli_query($connect, $searchSQL);
    }

    //delete all images in temp_qrimage
    $directory = 'temp_qrimage/';

    // Get all files in the directory
    $files = glob($directory . '*');

    // Loop through each file and delete it
    foreach ($files as $file) {
        // Use unlink to delete the file
        if (is_file($file)) {
            unlink($file);
        }
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
    <link rel="stylesheet" href="assets/css/list.css">
    <link rel="stylesheet" href="assets/css/buttoncrud.css">
    <link rel="icon" href="https://i.imgur.com/DnvtJhq.png">
    <title>Admin <?php echo $equipCategory ?> List | iQReS</title>
</head>

<body>
    <div class="container">
        <!-- Sidebar Section -->
        <?php adminSidebar($pageName); ?>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1><?php echo $equipCategory ?> List</h1>
            <!-- New Users Section -->
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
                            <button class="Btn add"  onclick="location.href = 'admin_equip_add.php?equipCategory=<?php echo $equipCategory ?>'">Add 
                                <svg class="svg add" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path></svg>
                            </button>
                        </div>
                    </div>
                    <table class="equipment-table">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Equipment ID</th>
                            <th>Equipment Name</th>
                            <th>Purchase Date</th>
                            <th>Register Date</th>
                            <th>QR Image</th>
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
                            <td><?php echo $row["equipID"] ?></td>
                            <td><?php echo $row["equipName"] ?></td>
                            <td><?php echo date('d-m-Y', strtotime($row["equipPurchaseDate"])) ?></td>
                            <td><?php echo date('d-m-Y', strtotime($row["equipRegisterDate"])) ?></td>
                            <td><a href="admin_equip_list.php?downloadQR=true&imgurLink=<?php echo $row["equipQRImg"] ?>&equipID=<?php echo $row["equipID"] ?>"><img class="qrImage" src="<?php echo $row["equipQRImg"] ?>" alt="qrcode"></a></td>
                            <td>
                                <div class="action_btn">
                                    <div>
                                        <button class="Btn edit" onclick="window.location.href = 'admin_equip_edit.php?equipID=<?php echo $row['equipID'] ?>'">Edit 
                                        <svg class="svg" viewBox="0 0 512 512">
                                            <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path></svg>
                                        </button>
                                    </div>
                                    <div>
                                        <button class="Btn del" onclick="window.location.href = 'function_deleteEquipment.php?equipID=<?php echo $row['equipID'] ?>'">Del 
                                        <svg class="svg del" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6 7H5v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7H6zm4 12H8v-9h2v9zm6 0h-2v-9h2v9zm.618-15L15 2H9L7.382 4H3v2h18V4z"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                            <?php
                                    $counter++;
                                }
                            ?>
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
</body>

</html>