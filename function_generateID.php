<?php
    function GenerateAdminID() {
        global $connect;
         // Function to generate a random three-digit number
         function generateRandomNumber() {
            return str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        }

        // Initial attempt to generate admin ID
        $generatedID = 'A' . generateRandomNumber();

        // Check if the generated ID already exists in the database
        $checkQuery = "SELECT userID FROM user WHERE userID = '$generatedID' AND userType = 'ADMIN'";
        $result = mysqli_query($connect, $checkQuery);

        // If the ID already exists, regenerate it until a unique one is found
        while (mysqli_num_rows($result) > 0) {
            $generatedID = 'A' . generateRandomNumber();
            $checkQuery = "SELECT userID FROM user WHERE userID = '$generatedID' AND userType = 'ADMIN'";
            $result = mysqli_query($connect, $checkQuery);
        }

        // Return the generated admin ID
        return $generatedID;
    }

    function GenerateStudentID() {
        global $connect;
    
        // Get the current year
        $currentYear = date("Y");
    
        // Generate a random 6-digit number
        $randomNumber = mt_rand(100000, 999999);
    
        // Concatenate the current year and the random number to form the student ID
        $studentID = $currentYear . $randomNumber;
    
        return $studentID;
    }

    function GenerateEquipID($equipCategory) {
        global $connect;
    
        // Get the category ID (cateID) based on the equipCategory
        $query = "SELECT cateID FROM categoryequipment WHERE cateName = '$equipCategory'";
        $result = mysqli_query($connect, $query);
    
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $cateID = $row['cateID'];
    
            // Generate a random 3-digit number
            $randomNumber = str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
    
            // Generate the new equipID
            $newID = $cateID . $randomNumber;
    
            // Check if the generated equipID already exists in the equipment table
            $checkQuery = "SELECT equipID FROM equipment WHERE equipID = '$newID'";
            $checkResult = mysqli_query($connect, $checkQuery);
    
            if ($checkResult && mysqli_num_rows($checkResult) > 0) {
                // If the generated equipID already exists, recursively call the function to generate a new one
                return GenerateEquipID($equipCategory);
            } else {
                // If the generated equipID is unique, return it
                return $newID;
            }
        } else {
            // Handle the case when the equipCategory is not found in the categoryequipment table
            return false;
        }
    }
    
?>