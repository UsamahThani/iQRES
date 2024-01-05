<?php
    $hostname = "localhost";
    $user = "root";
    $password = "";
    $database = "iqres";

    $connect = mysqli_connect($hostname, $user, $password, $database) OR DIE ("Connection failed!");
?>