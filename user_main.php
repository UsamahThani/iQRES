<?php
    session_start();
    include ("function_checkSession.php");
    include ("function_userSidebar.php");
    include ("function_profile.php");
    require "dbconnect.php";
    checkLogin($_SESSION["userId"]);
    $_SESSION["userId"];
    $pageName = "main"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="https://i.imgur.com/DnvtJhq.png">
    <title>Main Page | iQReS</title>
</head>

<body>

    <div class="container">
        <!-- Sidebar Section -->
        <?php displaySidebar($pageName); ?>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Main Page</h1>
            <!-- Analyses -->
            <div class="analyse">
                <div class="borrows">
                    <div class="status">
                        <div class="info">
                            
                            <h3><strong>Currently Borrowing</strong></h3>
                            <ol>
                            <?php
                            //find borrowing data for the current user from db 
                                $borrowSQL = "SELECT * FROM BORROW WHERE STUDENTID = " .$_SESSION["userId"] . " AND borrowStatus = 'BORROWING'"; 
                                $borrowResult = mysqli_query($connect, $borrowSQL);
                                if (mysqli_num_rows($borrowResult) > 0) {
                                    while ($row = mysqli_fetch_array($borrowResult)) {
                            ?>
                                <li><?php echo $row["equipCategory"] . " | " . $row["equipID"] ?></li>
                            <?php
                                    }
                                } else {
                            ?>
                                </ol>
                                <br>
                                <p style="color: lime;">No equipment borrowed currently</p>
                            <?php
                                }
                            ?>
                            </ol>
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
                            <h1 style="color: rgb(62, 236, 62);"><?php echo $numEquipAvailable ?></h1>
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
                    <div class="date-time">
                        <div id="date"> </div>
                        <div id="time"> </div>                        
                    </div>
                </div>
            </div>
            <!-- End of Analyses -->

            <!-- New Users Section -->
            <div class="contact">
                <h2>Contact Us</h2>
                <div class="contact-list">
                    <div class="contact-method" onclick="phoneNum()">
                        <div class="contact-icon">
                            <i class='bx bx-phone-call' ></i>
                        </div>
                        <div class="contact-desc">
                            Call
                        </div>
                    </div>
                    <div class="contact-method" onclick="window.open('https://goo.gl/maps/CDH2KcWy7SHWmBGi7');">
                        <div class="contact-icon">
                            <i class='bx bx-map' ></i>
                        </div>
                        <div class="contact-desc">
                            Location
                        </div>
                    </div>
                    <div class="contact-method" onclick="window.open('https://www.facebook.com/unitsukanuitmkelantan/?locale=ms_MY');">
                        <div class="contact-icon">
                            <i class='bx bxl-facebook-circle'></i>
                        </div>
                        <div class="contact-desc">
                            Facebook
                        </div>
                    </div>
                    <div class="contact-method" onclick="window.open('https://www.instagram.com/sukan_uitmkelantan/');">
                        <div class="contact-icon">
                            <i class='bx bxl-instagram'></i>
                        </div>
                        <div class="contact-desc">
                            Instagram
                        </div>
                    </div>
                    <div class="contact-method" onclick="window.open('https://twitter.com/unitsukanuitmck?lang=en');">
                        <div class="contact-icon">
                            <i class='bx bxl-twitter' ></i>
                        </div>
                        <div class="contact-desc">
                            Twitter
                        </div>
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
    <script>
        function updateDateTime() {
            // Get the current date and time in the Malaysia time zone
            const malaysiaTimeZone = 'Asia/Kuala_Lumpur';
            const options = { timeZone: malaysiaTimeZone };
            const currentDateTime = new Date().toLocaleString('en-US', options);
    
            // Extract and display the date
            const dateElement = document.getElementById('date');
            const date = new Date(currentDateTime);
            const dateString = date.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            dateElement.textContent = dateString;
    
            // Extract and display the time
            const timeElement = document.getElementById('time');
            const timeString = date.toLocaleTimeString('en-US', { hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: false });
            timeElement.textContent = timeString;
        }
    
        // Update the date and time every second
        setInterval(updateDateTime, 1000);
    
        // Initial update
        updateDateTime();
    </script>
</body>

</html>