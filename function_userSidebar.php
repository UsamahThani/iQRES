<?php
    function displaySidebar($pageName) {
        $active = "class='active'";

        ?>
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img id="logo-img" src="https://i.ibb.co/X38FYsM/iqreslogoblack.png">
                    <h2>i<span class="danger">QReS</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">
                        close
                    </span>
                </div>
            </div>

            <div class="sidebar">
                
                <a href="user_main.php" <?php if ($pageName == "main") echo $active ?>>
                    <span class="material-icons-sharp">
                        <i class='bx bx-home' ></i>
                    </span>
                    <h3>Main Page</h3>
                </a>
                
                <a href="user_equipments.php" <?php if ($pageName == "equipment") echo $active ?>>
                    <span class="material-icons-sharp">
                        <i class='bx bx-qr-scan' ></i>
                    </span>
                    <h3>Equipments</h3>
                </a>
               
                <a href="user_history.php" <?php if ($pageName == "history") echo $active ?>>
                    <span class="material-icons-sharp">
                        receipt_long
                    </span>
                    <h3>History</h3>
                </a>
                <a href="user_feedback.php"<?php if ($pageName == "feedback") echo $active ?>>
                    <span class="material-icons-sharp">
                        summarize
                    </span>
                    <h3>Feedback</h3>
                </a>
                <a href="function_logout.php">
                    <span class="material-icons-sharp">
                        logout
                    </span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>
        <?php
    }

    function adminSidebar($pageName) {
        $active = "class='active'";
        ?>
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img id="logo-img" src="https://i.ibb.co/X38FYsM/iqreslogoblack.png">
                    <h2>i<span class="danger">QReS</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">
                        close
                    </span>
                </div>
            </div>

            <div class="sidebar">
                <a href="admin_main.php" <?php if ($pageName == "main") echo $active ?>>
                    <span class="material-icons-sharp">
                        <i class='bx bx-home' ></i>
                    </span>
                    <h3>Home</h3>
                </a>
                <a href="admin_admin.php" <?php if ($pageName == "admin") echo $active ?>>
                    <span class="material-icons-sharp">
                        <i class='bx bx-user-circle'></i>
                    </span>
                    <h3>Admin</h3>
                </a>
                <a href="admin_student.php" <?php if ($pageName == "student") echo $active ?>>
                    <span class="material-icons-sharp" >
                        <i class='bx bx-user'></i>
                    </span>
                    <h3>Student</h3>
                </a>
                <a href="admin_equipments.php" <?php if ($pageName == "equipment") echo $active ?>>
                    <span class="material-icons-sharp">
                        <i class='bx bx-football'></i>
                    </span>
                    <h3>Equipments</h3>
                </a>
                <a href="admin_history.php" <?php if ($pageName == "history") echo $active ?>>
                    <span class="material-icons-sharp">
                        receipt_long
                    </span>
                    <h3>History</h3>
                </a>
                <a href="admin_feedback.php" <?php if ($pageName == "feedback") echo $active ?>>
                    <span class="material-icons-sharp">
                        summarize
                    </span>
                    <h3>Feedback</h3>
                </a>
                <a href="function_logout.php">
                    <span class="material-icons-sharp">
                        logout
                    </span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>
        <?php
    }

?>