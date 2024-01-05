<?php
    session_start();
    require "dbconnect.php";

    //call userId to check which user
    $userId = $_POST["userId"];
    $userPass = $_POST["userPass"];

    //check the login is from student or admin
    if (preg_match('/^\d{10}$/', $userId)){
        //user is student

        //retrieve data from db
        $query = "SELECT * FROM USER WHERE userId = '$userId'";
        $result = mysqli_query($connect, $query);

        if (mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            $hashedPassword = $row["userPass"];

            //decrypt hashed password
            if (password_verify( $userPass, $hashedPassword)){
                //set userId in the session
                $_SESSION["userId"] = $userId;
                $_SESSION["userType"] = $row["userType"];
                header("Location: user_main.php");
                exit();
            } else{
                echo "<script>alert('Wrong userId or password! Please try again.'); window.location.href = 'index.php'</script>";
                exit;
            }
        } else {
            echo "<script>alert('User ID not found!'); window.location.href = 'index.php'</script>";
            exit;
        }

    }elseif (preg_match('/^A\d{3}$/i', $userId)){
        //user is admin

         //retrieve data from db
         $query = "SELECT * FROM USER WHERE userId = '$userId'";
         $result = mysqli_query($connect, $query);
 
         if (mysqli_num_rows($result) > 0){
             $row = mysqli_fetch_array($result);
             $hashedPassword = $row["userPass"];
 
             //decrypt hashed password
             if (password_verify( $userPass, $hashedPassword)){
                 //set userId in the session
                 $_SESSION["userId"] = $userId;
                 $_SESSION["userType"] = $row["userType"];
                 header("Location: admin_main.php");
                 exit();
             } else{
                 echo "<script>alert('Wrong userId or password! Please try again.'); window.location.href = 'index.php'</script>";
                 exit;
             }
         } else {
             echo "<script>alert('User ID not found!'); window.location.href = 'index.php'</script>";
             exit;
         }
    }else{
        echo "<script>alert('Failed to login! Please ask admin for further information.'); window.location.href = 'index.php'</script>";
        exit;
    }
?>