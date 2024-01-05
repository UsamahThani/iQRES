<?php
    session_start();
    include ("function_checkSession.php");
    include ("function_userSidebar.php");
    include ("function_profile.php");
    include ("function_lineChart.php");
    require "dbconnect.php";
    checkLogin($_SESSION["userId"]);
    $_SESSION["userId"] = strtoupper($_SESSION["userId"]);
    $pageName = "main"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/adminstyle.css">
    <link rel="icon" href="https://i.imgur.com/DnvtJhq.png">
    <title>Admin Main Page | iQReS</title>
</head>

<body>
    <div class="container">
        <!-- Sidebar Section -->
        <?php adminSidebar($pageName); ?>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Admin Main Page</h1>
            <!-- Analyses -->
            
            <div class="analyse">
                <div class="borrows">
                    <div class="text">
                        <div><h3><strong>In/Out Equipments</strong></h3></div>
                        <div class="tooltip">
                            <i class='bx bx-info-circle'></i>
                            <span class="tooltiptext">
                                <span style="color: rgb(62, 236, 62);">RT</span>: Returned equipments <br>
                                <span style="color: red;"> BR</span>: Borrowed equipments <br>
                            </span>
                        </div>
                    </div>
                    <div class="status">
                        <div class="info">
                            <table class="equipment_table">
                                <?php
                                    $green = "color: rgb(62, 236, 62);";
                                    $red = "color: red;";
                                    $returned = "RT";
                                    $borrowed = "BR";
                                    //find the borrowing data 
                                    $borrowSQL = "SELECT * FROM borrow";
                                    $borrowResult = mysqli_query($connect, $borrowSQL);
                                    
                                    if (mysqli_num_rows($borrowResult) > 0) {
                                        while ($row = mysqli_fetch_array($borrowResult)) {
                                            $equipID = $row["equipID"];
                                            $equipCategory = $row["equipCategory"];
                                            $borrowStatus = $row["borrowStatus"];

                                            if ($borrowStatus == "BORROWING") {
                                ?>
                                <tr>
                                    <td style="<?php echo $red; ?>"><?php echo $borrowed ?></td>
                                    <td><?php echo $equipID ?></td>
                                    <td><?php echo $equipCategory ?></td>
                                </tr>
                                <?php
                                            } else if ($borrowStatus == "RETURNED") {
                                                ?>
                                <tr>
                                    <td style="<?php echo $green; ?>"><?php echo $returned ?></td>
                                    <td><?php echo $equipID ?></td>
                                    <td><?php echo $equipCategory ?></td>
                                </tr>
                                                <?php
                                            }
                                        }
                                    } else {
                                        echo "No data found.";
                                    }
                                ?>
                                
                            </table>
                        </div>
                    </div>
                </div>
                <div class="equipments">
                    <div class="status">
                        <div class="info">
                            <h3>Equipments Available</h3>
                            <?php
                                //find number of available equipments
                                $isAvailableSQL = "SELECT COUNT(*) as available_count FROM equipment WHERE equipIsAvailable = 1";
                                $isAvailableResult = mysqli_query($connect, $isAvailableSQL);
                                $numEquipAvailable = 0;
                                if ($isAvailableResult) {
                                    $row = mysqli_fetch_array($isAvailableResult);
                                    $numEquipAvailable = $row["available_count"];
                                } else {
                                    // Handle query error if needed
                                    die("Error in SQL query: " . mysqli_error($connect));
                                }
                            ?>
                            <h1><span style="color: rgb(62, 236, 62);"><?php echo $numEquipAvailable ?></span> units</h1>
                        </div>
                        <div class="progresss">
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <div class="skill-item center-block">
                                    <div class="chart-container">
                                    <?php
                                            //find number of equipment not available
                                            $notAvailableSQL = "SELECT COUNT(*) AS unavailable_count FROM equipment WHERE equipIsAvailable = 0;";
                                            $notAvailableResult = mysqli_query($connect, $notAvailableSQL);
                                            $numEquipNotAvailable = 0;
                                            if ($notAvailableResult) {
                                                $row = mysqli_fetch_array($notAvailableResult);
                                                $numEquipNotAvailable = $row["unavailable_count"];
                                            } else {
                                                die("Error in SQL query: ". mysqli_error($connect));
                                            }

                                            $equipTotal = $numEquipAvailable + $numEquipNotAvailable;
                                            
                                            //count the percentage
                                            $equipPercent = ($numEquipAvailable / $equipTotal) * 100;

                                        ?>
                                        <div class="chart " data-percent="<?php echo $equipPercent; ?>" data-bar-color="#23afe3">
                                            <span class="percent" data-after="%"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="searches">
                    <div class="status">
                        <div class="info">
                            <h3>Feedback</h3>
                            <?php
                                // find total of feedback
                                $feedbackSQL = "SELECT * FROM feedback";
                                $feedbackResult = mysqli_query($connect, $feedbackSQL);
                                $totalFeedback = 0;

                                if ($feedbackResult) {
                                    $totalFeedback = mysqli_num_rows($feedbackResult);
                                } else {
                                    die("Error: " . mysqli_error($connect));
                                }

                                // check if there are feedback entries before calculating percentage
                                if ($totalFeedback > 0) {
                                    // find number of feedback status pending
                                    $pendingSQL = "SELECT COUNT(*) AS pendingCount FROM feedback WHERE feedbackStatus = 'PENDING'";
                                    $pendingResult = mysqli_query($connect, $pendingSQL);
                                    $numPending = 0;

                                    if ($pendingResult) {
                                        $row = mysqli_fetch_array($pendingResult);
                                        $numPending = $row["pendingCount"];
                                    } else {
                                        die("Error in SQL query" . mysqli_error($connect));
                                    }

                                    // count num of replied
                                    $numReplied = $totalFeedback - $numPending;

                                    // count percentage of feedback
                                    $feedbackPercent = ($numReplied / $totalFeedback) * 100;

                                    // change color if 100% feedback replies
                                    $colorChart = $feedbackPercent == 100 ? "#3eec3e" : "#e81a35";
                                } else {
                                    // Set default values if there are no feedback entries
                                    $numPending = 0;
                                    $numReplied = 0;
                                    $feedbackPercent = 0;
                                    $colorChart = "#e81a35"; // Default color for zero feedback entries
                                }
                            ?>
                            <h1 style="font-size: 18px;"><span style="color: <?php echo $colorChart; ?>;"><?php echo $numPending; ?></span> unread message(s)</h1>
                        </div>
                        <div class="progresss">
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <div class="skill-item center-block">
                                    <div class="chart-container">
                                        <div class="chart " data-percent="<?php echo $feedbackPercent; ?>" data-bar-color="<?php echo $colorChart; ?>">
                                            <span class="percent" data-after="%"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Analyses -->

            <!-- New Users Section -->
            <div class="contact">
                <h2>Sport Equipments Data Analysis</h2>
                <div class="contact-list">
                    <div class="lineChart">
                        <canvas id="myChart"></canvas>
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
    <script src="plugins/jquery-2.2.4.min.js"></script>
    <script src="plugins/jquery.appear.min.js"></script>
    <script src="plugins/jquery.easypiechart.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php DisplayLineChart(); ?>     
    
    <script>
            'use strict';

        var $window = $(window);

        function run()
        {
            var fName = arguments[0],
                aArgs = Array.prototype.slice.call(arguments, 1);
            try {
                fName.apply(window, aArgs);
            } catch(err) {
                
            }
        };
        
        /* chart
        ================================================== */
        function _chart ()
        {
            $('.progresss').appear(function() {
                setTimeout(function() {
                    $('.chart').easyPieChart({
                        easing: 'easeOutElastic',
                        delay: 3000,
                        barColor: '#369670',
                        trackColor: 'transparent',
                        scaleColor: false,
                        lineWidth: 10,
                        trackWidth: 10,
                        size: 100,
                        lineCap: 'round',
                        onStep: function(from, to, percent) {
                            this.el.children[0].innerHTML = Math.round(percent);
                        }
                    });
                }, 150);
            });
        };
        

        $(document).ready(function() {
            run(_chart);
        });

    </script>
    <script>
        function phoneNum() {
            const phoneNumber = '0388881901'; // Replace with your actual phone number
            const tempInput = document.createElement('input');
            tempInput.value = phoneNumber;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            
            // You can add a confirmation alert or message here
            alert('Phone number copied to clipboard: ' + phoneNumber);
        }
    </script>
    
</body>

</html>