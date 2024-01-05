<?php
    function rightSection() {
        global $connect;

        ?>
        <div class="right-section">
            <div class="nav">
                <button id="menu-btn">
                    <span class="material-icons-sharp">
                        menu
                    </span>
                </button>
                <div class="dark-mode">
                    <span class="material-icons-sharp active">
                        light_mode
                    </span>
                    <span class="material-icons-sharp">
                        dark_mode
                    </span>
                </div>
                <?php
                    $userSQL = "SELECT * FROM user WHERE userID = ?";
                    $userStmt = mysqli_prepare($connect, $userSQL);
                    
                    if ($userStmt) {
                        mysqli_stmt_bind_param($userStmt,"s", $_SESSION["userId"]);
                        mysqli_stmt_execute($userStmt);

                        $userResult = mysqli_stmt_get_result($userStmt);

                        if ($userResult) {
                            $row = mysqli_fetch_array($userResult);
                            if ($row) {
                                $userName = $row["userName"];
                                $userType = $row["userType"];
                                $userImg = $row["userImg"];

                                //Extract the first name
                                $nameParts = explode(" ", $userName);
                                $firstName = $nameParts[0];
                ?>
                <div class="profile">
                    <div class="info">
                        <p>Hey, <b><?php echo $firstName; ?></b></p> 
                        <small class="text-muted"><?php echo $userType; ?></small>
                    </div>
                    <div class="profile-photo">
                        <img src="<?php echo $userImg ?>">
                    </div>
                </div>
                <?php
                        } else {
                            echo "User data not found.";
                        }
                        mysqli_free_result($userResult);
                    } else {
                        echo "Query failed: " . mysqli_error($connect);
                    }
                ?>

            </div>
            <!-- End of Nav -->

            <div class="user-profile">
                <div class="logo">
                    <img src="<?php echo $userImg ?>">
                    <h2><?php echo $_SESSION["userId"]; ?></h2>
                    <p><?php echo $userName; ?></p>
                </div>
            </div>
        </div>
        <?php
                    } else {
                        echo "Prepare statement failed: " . mysqli_error($connect);
                    }
    }
?>